<div id="ai-chatbot" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button id="chat-button" class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 transition-all duration-300 focus:outline-none">
        <i class="fas fa-robot text-2xl"></i>
    </button>
    
    <!-- Chat Window -->
    <div id="chat-window" class="hidden absolute bottom-20 right-0 w-80 md:w-96 bg-white rounded-lg shadow-xl overflow-hidden transition-all duration-300 transform scale-95 opacity-0">
        <!-- Chat Header -->
        <div class="bg-indigo-600 text-white p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-robot mr-2"></i>
                <h3 class="font-medium">CT ZONE Assistant</h3>
            </div>
            <div class="flex space-x-2">
                <button id="clear-chat" title="Clear conversation" class="text-white hover:text-indigo-200 focus:outline-none">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button id="close-chat" class="text-white hover:text-indigo-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" class="p-4 h-80 overflow-y-auto">
            <div class="chat-message bot">
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                        <i class="fas fa-robot text-indigo-600"></i>
                    </div>
                    <div class="bg-indigo-100 rounded-lg p-3 max-w-xs md:max-w-md">
                        <p>Hello! I'm the CT ZONE AI Assistant. How can I help you today?</p>
                    </div>
                </div>
            </div>
            <!-- More messages will be added dynamically -->
        </div>
        
        <!-- Chat Input -->
        <div class="border-t border-gray-200 p-4 bg-gray-50">
            <form id="chat-form" class="flex items-center">
                <input 
                    type="text" 
                    id="chat-input" 
                    class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Type your message..."
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700 focus:outline-none"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div class="text-xs text-gray-500 mt-2 text-center">
                Powered by AI - Ask me anything about our products and services!
            </div>
        </div>
    </div>
</div> 