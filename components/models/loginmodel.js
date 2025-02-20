export default class LoginModel {
    async login(mail, password) {
        console.log(" Sending login request to backend...");
        console.log(" Payload:", { mail, password });

        try {
            const response = await fetch("http://localhost:8000/api/index.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ mail, password })
            });

            console.log(" Response Status:", response.status);
            console.log(" Response Headers:", response.headers);

            if (!response.ok) {
                throw new Error(`Login request failed: ${response.status} ${response.statusText}`);
            }

            const text = await response.text();
            console.log("🔍 Raw Response:", text);
            const data = JSON.parse(text); // Now manually parse
            
                
            return data;
        } catch (error) {
            console.error("❌ Login Error:", error);
            throw error; 
        }
    }
}