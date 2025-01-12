document.getElementById('feedback-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const feedbackType = document.getElementById('feedback-type').value;
    const filterCategory = document.getElementById('filter-category').value;
    const feedbackMessage = document.getElementById('feedback-message').value;

    try {
        const response = await fetch('../backend/process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ feedbackType, filterCategory, feedbackMessage }),
        });

        const result = await response.json();

        if (result.success) {
            alert('Feedback submitted successfully!');
            document.getElementById('feedback-form').reset();
        } else {
            console.error(`Error: ${result.message}`);
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Network or unexpected error:', error);
        alert('An unexpected error occurred. Please try again later.');
    }
});
