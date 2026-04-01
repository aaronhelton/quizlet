# Quizlet Plugin for DokuWiki

A simple quiz plugin for DokuWiki that allows page editors to create interactive quizzes with scoring.

## Syntax

Use the `<quiz>` tag to create a quiz block. Within the tag:
- Start each question with `? `
- Mark the correct answer with `+ `
- Mark incorrect answers with `- `
- Separate multiple questions with a blank line

## Example

```
<quiz>
? What is the capital of France?
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
