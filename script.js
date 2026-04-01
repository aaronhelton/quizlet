/**
 * DokuWiki Plugin Quizlet (JavaScript Component)
 * 
 * Handles the interactive quiz functionality
 * @license    GPL 2.0
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all quiz containers
    const quizzes = document.querySelectorAll('.quizlet-container');
    
    quizzes.forEach(function(quiz) {
        const quizId = quiz.id;
        const submitBtn = quiz.querySelector('.quizlet-submit');
        const resetBtn = quiz.querySelector('.quizlet-reset');
        
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                submitQuiz(quizId);
            });
        }
        
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                resetQuiz(quizId);
            });
        }

        // Add click handlers to answers for immediate feedback
        const answers = quiz.querySelectorAll('.quizlet-answer input[type="radio"]');
        answers.forEach(function(answer) {
            answer.addEventListener('change', function() {
                showAnswerFeedback(this);
            });
        });
    });
});

function showAnswerFeedback(answerElement) {
    const label = answerElement.closest('.quizlet-answer');
    const question = answerElement.closest('.quizlet-question');
    
    // Remove previous feedback classes
    question.querySelectorAll('.quizlet-answer').forEach(function(ans) {
        ans.classList.remove('correct', 'incorrect', 'selected');
    });
    
    // Add selected class to current answer
    label.classList.add('selected');
    
    // Show if correct or not
    if (answerElement.dataset.correct === 'true') {
        label.classList.add('correct');
    } else {
        label.classList.add('incorrect');
    }
}

function submitQuiz(quizId) {
    const quiz = document.getElementById(quizId);
    const questions = quiz.querySelectorAll('.quizlet-question');
    const scoreDiv = quiz.querySelector('.quizlet-score');
    const scoreText = scoreDiv.querySelector('.quizlet-score-text');
    
    let totalQuestions = questions.length;
    let correctAnswers = 0;
    let answeredQuestions = 0;
    
    // Calculate score
    questions.forEach(function(question, index) {
        const selectedAnswer = question.querySelector('input[type="radio"]:checked');
        
        if (selectedAnswer) {
            answeredQuestions++;
            if (selectedAnswer.dataset.correct === 'true') {
                correctAnswers++;
            }
        }
    });
    
    // Check if all questions answered
    if (answeredQuestions < totalQuestions) {
        alert('Please answer all questions before submitting.');
        return;
    }
    
    // Calculate percentage
    const percentage = Math.round((correctAnswers / totalQuestions) * 100);
    
    // Display result
    scoreText.innerHTML = 'You scored <strong>' + correctAnswers + ' out of ' + 
                          totalQuestions + '</strong> (' + percentage + '%)';
    scoreDiv.style.display = 'block';
    
    // Add pass/fail styling
    if (percentage >= 70) {
        scoreDiv.classList.add('pass');
    } else {
        scoreDiv.classList.add('fail');
    }
}

function resetQuiz(quizId) {
    const quiz = document.getElementById(quizId);
    
    // Clear all selections
    quiz.querySelectorAll('input[type="radio"]').forEach(function(input) {
        input.checked = false;
    });
    
    // Remove feedback classes
    quiz.querySelectorAll('.quizlet-answer').forEach(function(answer) {
        answer.classList.remove('correct', 'incorrect', 'selected');
    });
    
    // Hide score
    const scoreDiv = quiz.querySelector('.quizlet-score');
    scoreDiv.style.display = 'none';
    scoreDiv.classList.remove('pass', 'fail');
}
