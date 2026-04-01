<?php
/**
 * DokuWiki Plugin Quizlet (Syntax Component)
 *
 * @license    GPL 2.0
 * @author     Aaron Helton
 */

if (!defined('DOKU_INC')) die();

class syntax_plugin_quizlet extends DokuWiki_Syntax_Plugin {

    public function getType() {
        return 'protected';
    }

    public function getPType() {
        return 'block';
    }

    public function getSort() {
        return 195;
    }

    public function connectTo($mode) {
        $this->Lexer->addEntryPattern('<quiz\b.*?>', $mode, 'plugin_quizlet');
    }

    public function postConnect() {
        $this->Lexer->addExitPattern('</quiz>', 'plugin_quizlet');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        if ($state == DOKU_LEXER_ENTER) {
            return array($state, '');
        }

        if ($state == DOKU_LEXER_EXIT) {
            return array($state, '');
        }

        if ($state == DOKU_LEXER_UNMATCHED) {
            $lines = explode("\n", $match);
            $questions = array();
            $current_question = null;

            foreach ($lines as $line) {
                $line = trim($line);
                
                if (empty($line)) {
                    continue;
                }

                // Question line
                if (substr($line, 0, 2) === '? ') {
                    if ($current_question !== null) {
                        $questions[] = $current_question;
                    }
                    $current_question = array(
                        'question' => substr($line, 2),
                        'answers' => array()
                    );
                }
                // Correct answer
                elseif (substr($line, 0, 2) === '+ ' && $current_question !== null) {
                    $current_question['answers'][] = array(
                        'text' => substr($line, 2),
                        'correct' => true
                    );
                }
                // Incorrect answer
                elseif (substr($line, 0, 2) === '- ' && $current_question !== null) {
                    $current_question['answers'][] = array(
                        'text' => substr($line, 2),
                        'correct' => false
                    );
                }
            }

            if ($current_question !== null) {
                $questions[] = $current_question;
            }

            return array($state, $questions);
        }
    }

    public function render($format, Doku_Renderer $renderer, $data) {
        if ($format != 'xhtml') {
            return false;
        }

        list($state, $questions) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            return true;
        }

        if (empty($questions)) {
            return false;
        }

        // Generate unique ID for this quiz
        static $quiz_counter = 0;
        $quiz_counter++;
        $quiz_id = 'quiz_' . $quiz_counter;

        $renderer->doc .= '<div class="quizlet-container" id="' . $quiz_id . '">';
        $renderer->doc .= '<div class="quizlet-questions">';

        foreach ($questions as $q_index => $question) {
            $renderer->doc .= '<div class="quizlet-question" data-question="' . $q_index . '">';
            $renderer->doc .= '<div class="quizlet-question-text">' . 
                hsc($question['question']) . 
                '</div>';
            $renderer->doc .= '<div class="quizlet-answers">';

            // Shuffle answers but keep track of correct one
            $answers = $question['answers'];
            $shuffled_answers = array();
            $correct_index = -1;

            foreach ($answers as $idx => $answer) {
                if ($answer['correct']) {
                    $correct_index = count($shuffled_answers);
                }
                $shuffled_answers[] = $answer;
            }

            // Simple shuffle (keep order for simplicity, or implement proper shuffle)
            // For now, we'll just keep order - shuffle can be added later

            foreach ($shuffled_answers as $a_index => $answer) {
                $answer_id = $quiz_id . '_q' . $q_index . '_a' . $a_index;
                $renderer->doc .= '<label class="quizlet-answer">';
                $renderer->doc .= '<input type="radio" name="' . $quiz_id . '_q' . $q_index . 
                    '" value="' . $a_index . '" data-correct="' . 
                    ($answer['correct'] ? 'true' : 'false') . '" id="' . $answer_id . '">';
                $renderer->doc .= '<span class="quizlet-answer-text">' . 
                    hsc($answer['text']) . 
                    '</span>';
                $renderer->doc .= '</label>';
            }

            $renderer->doc .= '</div>';
            $renderer->doc .= '</div>';
        }

        $renderer->doc .= '</div>';
        $renderer->doc .= '<div class="quizlet-controls">';
        $renderer->doc .= '<button class="quizlet-submit" data-quiz="' . $quiz_id . '">Submit Quiz</button>';
        $renderer->doc .= '<button class="quizlet-reset" data-quiz="' . $quiz_id . '">Reset</button>';
        $renderer->doc .= '</div>';
        $renderer->doc .= '<div class="quizlet-score" id="' . $quiz_id . '_score" style="display:none;">';
        $renderer->doc .= '<div class="quizlet-score-text"></div>';
        $renderer->doc .= '</div>';
        $renderer->doc .= '</div>';

        return true;
    }
}
?>
