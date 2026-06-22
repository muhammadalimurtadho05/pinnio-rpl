// ============================================
// PINTHREAD — Chat JS
// ============================================

document.addEventListener("DOMContentLoaded", () => {
    // Scroll to bottom of chat automatically when page loads
    const chatMessages = document.getElementById("chatMessages");
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Start polling for new messages every 3 seconds
        const partnerUsername = document.getElementById("partnerUsername")?.value;
        if (partnerUsername) {
            setInterval(() => pollMessages(partnerUsername), 3000);
        }
    }
});

async function sendChatMessage(e) {
    e.preventDefault();
    
    const input = document.getElementById("chatInput");
    const partnerId = document.getElementById("partnerId").value;
    const currentUserId = document.getElementById("currentUserId").value;
    const text = input.value.trim();
    const chatMessages = document.getElementById("chatMessages");
    
    if (!text) return;
    
    // Optimistically add message to UI
    const now = new Date();
    const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    const bubbleWrapper = document.createElement("div");
    bubbleWrapper.className = "message-bubble-wrapper d-flex justify-content-end";
    bubbleWrapper.innerHTML = `
        <div class="message-bubble" style="max-width:75%; padding:10px 16px; border-radius:18px; font-size:15px; background:var(--pin-yellow);color:var(--pin-dark);border-bottom-right-radius:4px;">
            ${escapeHtml(text)}
            <div style="font-size:11px; opacity:0.7; text-align: right; margin-top:4px;">
                ${timeStr}
            </div>
        </div>
    `;
    chatMessages.appendChild(bubbleWrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Clear input
    input.value = "";
    
    // Send to server
    try {
        const response = await fetch("/api/chat/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                receiver_id: partnerId,
                message_text: text
            }),
        });

        const data = await response.json();
        
        if (!response.ok || !data.success) {
            console.error("Failed to send message:", data.message);
            // In a real app, we'd mark the optimistic bubble as failed
        }
    } catch (error) {
        console.error("Error sending message:", error);
    }
}

// Polling function
let lastPollData = ""; // simple way to check for changes (by comparing stringified array)
async function pollMessages(username) {
    try {
        const response = await fetch(`/chat/${username}/poll`);
        const data = await response.json();
        
        if (response.ok && data.success) {
            const currentDataStr = JSON.stringify(data.data);
            
            // First time setting lastPollData or if messages changed
            if (lastPollData !== "" && lastPollData !== currentDataStr) {
                // Re-render chat
                renderMessages(data.data);
            }
            lastPollData = currentDataStr;
        }
    } catch (error) {
        console.error("Error polling messages:", error);
    }
}

function renderMessages(messages) {
    const chatMessages = document.getElementById("chatMessages");
    const currentUserId = parseInt(document.getElementById("currentUserId").value);
    
    // Only re-render if we actually have container
    if (!chatMessages) return;
    
    // We remember scroll position to see if we should auto-scroll
    const isAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight + 50;
    
    chatMessages.innerHTML = "";
    
    messages.forEach(msg => {
        const isMine = parseInt(msg.sender_id) === currentUserId;
        const time = new Date(msg.sent_at);
        const timeStr = time.getHours().toString().padStart(2, '0') + ':' + time.getMinutes().toString().padStart(2, '0');
        
        const bubbleWrapper = document.createElement("div");
        bubbleWrapper.className = `message-bubble-wrapper d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'}`;
        
        const style = isMine 
            ? "background:var(--pin-yellow);color:var(--pin-dark);border-bottom-right-radius:4px;" 
            : "background:var(--pin-card);color:var(--pin-white);border:1px solid var(--pin-border);border-bottom-left-radius:4px;";
            
        const align = isMine ? 'right' : 'left';
        
        bubbleWrapper.innerHTML = `
            <div class="message-bubble" style="max-width:75%; padding:10px 16px; border-radius:18px; font-size:15px; ${style}">
                ${escapeHtml(msg.message_text)}
                <div style="font-size:11px; opacity:0.7; text-align: ${align}; margin-top:4px;">
                    ${timeStr}
                </div>
            </div>
        `;
        
        chatMessages.appendChild(bubbleWrapper);
    });
    
    if (isAtBottom) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Utility to prevent XSS in optimistic rendering
function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}
