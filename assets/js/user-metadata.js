jQuery(document).ready(function($) {
    const questions = enduraMetadata.questions;
    const userResponses = {};

    async function askQuestions() {
        for (const key in questions) {
            if (questions.hasOwnProperty(key)) {
                let questionText = questions[key];

                // Replace [First Name] placeholder if previously captured
                if (key !== 'endura_first_name' && userResponses.endura_first_name) {
                    questionText = questionText.replace('[First Name]', userResponses.endura_first_name);
                }

                // Prompt user for answer (temporary testing method)
                const answer = prompt(questionText);

                // Save user answer
                userResponses[key] = answer;
            }
        }

        // Display captured responses clearly in console
        console.log('Captured User Responses:', userResponses);

        // After this step works, we'll send these answers via AJAX
        // saveUserMetadata(userResponses);
    }

    // Start the Q&A process
    askQuestions();
});