/**
 * CT ZONE AI Chatbot
 * 
 * Using OpenAI's GPT-3.5 Turbo to provide intelligent responses to customer queries.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const chatButton = document.getElementById('chat-button');
    const chatWindow = document.getElementById('chat-window');
    const closeChat = document.getElementById('close-chat');
    const clearChat = document.getElementById('clear-chat');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    
    // Toggle chat window
    chatButton.addEventListener('click', function() {
        chatWindow.classList.toggle('hidden');
        
        // If opening the chat window, add animation classes
        if (!chatWindow.classList.contains('hidden')) {
            // Small delay to ensure the 'hidden' class is processed first
            setTimeout(() => {
                chatWindow.classList.add('scale-100', 'opacity-100');
                chatWindow.classList.remove('scale-95', 'opacity-0');
                chatInput.focus();
            }, 50);
        } else {
            chatWindow.classList.remove('scale-100', 'opacity-100');
            chatWindow.classList.add('scale-95', 'opacity-0');
        }
    });
    
    // Close chat window
    closeChat.addEventListener('click', function() {
        chatWindow.classList.remove('scale-100', 'opacity-100');
        chatWindow.classList.add('scale-95', 'opacity-0');
        
        // Small delay to ensure the animation is visible
        setTimeout(() => {
            chatWindow.classList.add('hidden');
        }, 300);
    });
    
    // Handle chat form submission
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;
        
        // Add user message to chat
        addMessage(message, 'user');
        
        // Clear input
        chatInput.value = '';
        
        // Add loading indicator
        const loadingId = showLoading();
        
        // Call the backend API
        fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            // Remove loading indicator
            hideLoading(loadingId);
            
            // Add AI response to chat
            if (data.response) {
                addMessage(data.response, 'bot');
            } else if (data.error) {
                // Use the user-friendly message if provided, otherwise fall back to default
                const errorMessage = data.user_message || "I'm having trouble connecting to my brain. Please try again in a moment.";
                addMessage(errorMessage, 'bot');
                console.error("Chatbot error:", data.error);
            }
        })
        .catch(error => {
            // Remove loading indicator
            hideLoading(loadingId);
            
            // Add error message
            addMessage("I'm having trouble connecting to my brain. Please try again in a moment.", 'bot');
            console.error("Chatbot fetch error:", error);
        });
    });
    
    // Clear chat history
    clearChat.addEventListener('click', function() {
        // Ask for confirmation
        if (confirm('Are you sure you want to clear the conversation history?')) {
            // Send a request to the backend to clear the session
            fetch('/chatbot/clear', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the chat messages in the UI except for the first welcome message
                    const welcomeMessage = chatMessages.querySelector('.chat-message');
                    chatMessages.innerHTML = '';
                    if (welcomeMessage) {
                        chatMessages.appendChild(welcomeMessage);
                    } else {
                        // If no welcome message exists, add one
                        addMessage("Hello! I'm the CT ZONE AI Assistant. How can I help you today?", 'bot');
                    }
                    
                    // Add a message indicating history was cleared
                    addMessage("Conversation history has been cleared. How can I help you?", 'bot');
                }
            })
            .catch(error => {
                console.error("Failed to clear chat history:", error);
            });
        }
    });
    
    // Show loading indicator
    function showLoading() {
        const loadingId = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.classList.add('chat-message', 'bot');
        loadingDiv.innerHTML = `
            <div class="flex items-start mb-4">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                    <i class="fas fa-robot text-indigo-600"></i>
                </div>
                <div class="bg-indigo-100 rounded-lg p-3 flex items-center space-x-2">
                    <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                    <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                    <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                </div>
            </div>
        `;
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return loadingId;
    }
    
    // Hide loading indicator
    function hideLoading(loadingId) {
        const loadingDiv = document.getElementById(loadingId);
        if (loadingDiv) {
            loadingDiv.remove();
        }
    }
    
    // Add a message to the chat
    function addMessage(message, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('chat-message', sender);
        
        if (sender === 'user') {
            messageDiv.innerHTML = `
                <div class="flex items-start justify-end mb-4">
                    <div class="bg-indigo-600 text-white rounded-lg p-3 max-w-xs md:max-w-md ml-auto">
                        <p>${escapeHtml(message)}</p>
                    </div>
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center ml-2">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                        <i class="fas fa-robot text-indigo-600"></i>
                    </div>
                    <div class="bg-indigo-100 rounded-lg p-3 max-w-xs md:max-w-md">
                        <p>${escapeHtml(message)}</p>
                    </div>
                </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Helper function to escape HTML
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}); 