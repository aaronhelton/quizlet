# Quizlet Plugin for DokuWiki

A simple quiz plugin for DokuWiki that allows page editors to create interactive quizzes with scoring.

## Syntax

Use the `<quiz>` tag to create a quiz block. Within the tag:
- Start each question with `? `
- Continue a question on following lines (before the first answer) for multi-line prompts
- Mark the correct answer with `+ `
- Mark incorrect answers with `- `
- Separate multiple questions with a blank line

## Example

```
<quiz>
? What is the capital of France?
Choose the best answer from the options below.
+ Paris
- London
- Berlin
- Madrid

? What is 2 + 2?
+ 4
- 3
- 5
- 6
</quiz>
```

## Features

- Multiple choice questions
- Single correct answer per question
- Score calculation
- Visual feedback for correct/incorrect answers
- Progress tracking
- Multi-language support (English and Spanish included)

## Localization

The plugin includes language files for multiple languages. Currently supported:
- **English** (`lang/en/lang.php`)
- **Spanish** (`lang/es/lang.php`)

DokuWiki automatically uses the language specified in its configuration. The quiz interface (buttons, messages, and results) will display in the appropriate language.

To add additional languages, create a new directory under `lang/` with the language code and add a `lang.php` file with the required translation strings.

## Installation

1. Download the quizlet plugin
2. Extract to your DokuWiki plugins directory: `lib/plugins/quizlet/`
3. Enable the plugin in DokuWiki admin panel

## Usage

Simply add the quiz syntax to your DokuWiki page. When rendered, users can:
1. Select an answer
2. See immediate feedback (correct/incorrect)
3. View their final score after completing the quiz
4. Reset and retake the quiz

## License

GPL 2.0
