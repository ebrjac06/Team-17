const form = document.getElementById('contactForm');

form.querySelectorAll("input, textarea").forEach(field => {
    field.addEventListener("input", () => {
        field.setCustomValidity("");
    });
});

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const firstName = form.first_name.value.trim();
    const lastName = form.last_name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();

    if (!firstName || !lastName || !email || !message) {
        if (!firstName) form.first_name.setCustomValidity("First name is required");
        if (!lastName) form.last_name.setCustomValidity("Last name is required");
        if (!email) form.email.setCustomValidity("Email is required");
        if (!message) form.message.setCustomValidity("Message is required");
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    try {
        const response = await fetch('contact_form.php', {
            method: 'POST',
            body: formData
        });

        const text = await response.text();
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('Response was not JSON:', text);
            alert("Server error. Please try again later.");
            return;
        }

        form.querySelectorAll("input, textarea").forEach(field => {
            field.setCustomValidity("");
        });

        if (data.status === "error") {
            const errorMessage = data.message.toLowerCase();

            if (errorMessage.includes("first name")) {
                form.first_name.setCustomValidity(data.message);
            }
            if (errorMessage.includes("last name")) {
                form.last_name.setCustomValidity(data.message);
            }
            if (errorMessage.includes("email")) {
                form.email.setCustomValidity(data.message);
            }
            if (errorMessage.includes("phone")) {
                form.phone.setCustomValidity(data.message);
            }
            if (errorMessage.includes("message") || errorMessage.includes("required")) {
                if (form.first_name.value === "") form.first_name.setCustomValidity("First name is required");
                if (form.last_name.value === "") form.last_name.setCustomValidity("Last name is required");
                if (form.email.value === "") form.email.setCustomValidity("Email is required");
                if (form.message.value === "") form.message.setCustomValidity("Message is required");
            }

            form.reportValidity();
            return;
        }

        if (data.status === "success") {
            alert("Message sent successfully!");
            form.reset();
        }

    } catch (error) {
        console.error('Error:', error);
        alert("Server error. Please try again later.");
    }
});
