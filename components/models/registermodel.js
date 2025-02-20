export default class RegisterModel {
    async register(firstname, preposition, lastname, mail, phonenumber, password) {
        console.log("Sending register request to backend...");
        console.log("Payload:", { firstname, preposition, lastname, mail, phonenumber, password });

        try {
            const response = await fetch("http://localhost:8000/api/front/toanocustomerfront.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    firstname: firstname,
                    preposition: preposition,
                    lastname: lastname,
                    mail: mail,
                    phonenumber: phonenumber,
                    password: password
                })
            });

            console.log("Response Status:", response.status);
            console.log("Response Headers:", response.headers);

            if (!response.ok) {
                throw new Error(`Register request failed: ${response.status} ${response.statusText}`);
            }

            const responseText = await response.text();
            console.log("Raw Server Response:", responseText);

            const data = JSON.parse(responseText);
            console.log("🟢 Server Response:", data);

            return data;
        } catch (error) {
            console.error("❌ Register Error:", error);
            throw error;
        }
    }
}