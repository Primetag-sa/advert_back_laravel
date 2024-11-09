

alert('hi')
(function() {
    var clientId = 'YOUR_CLIENT_ID'; // Replace with actual client ID
    var trackingUrl = 'https://your-laravel-platform.com/track'; // Replace with your Laravel backend URL
    var startTime = new Date(); // Time when the page loads
    var clickCount = 0; // Initialize click counter

    // Function to collect visitor data
    function collectData(extraData = {}) {
        return {
            client_id: clientId, // Pass client_id
            url: window.location.href, // Current page URL
            title: document.title, // Title of the current page
            referrer: document.referrer, // Referring URL
            user_agent: navigator.userAgent, // Browser user agent
            screen_width: window.screen.width, // Device screen width
            screen_height: window.screen.height, // Device screen height
            timestamp: new Date().toISOString(), // Current time
            ...extraData // Merge additional data like time spent and clicks
        };
    }

    // Send visitor data to Laravel backend
    function sendTrackingData(data) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", trackingUrl, true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(data));
    }

    // Track clicks on the page
    document.addEventListener('click', function() {
        clickCount++; // Increment click count
    });

    // Send tracking data when the user leaves the page
    window.onbeforeunload = function() {
        var endTime = new Date(); // Time when the user leaves
        var timeSpent = (endTime - startTime) / 1000; // Time spent in seconds

        // Collect additional data (time spent and click count)
        var data = collectData({
            time_spent: timeSpent, // Time spent on page
            click_count: clickCount // Number of clicks made
        });

        // Send the data to the backend
        sendTrackingData(data);
    };

})();
