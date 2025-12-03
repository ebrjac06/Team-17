const form = document.getElementById('contactForm');

form.querySelectorAll("input, textarea").forEach(field => {
    field.addEventListener("input", () => {
        field.setCustomValidity("");
    });
});

form.addEventListener('submit', async function (e) {
    e.preventDefault(); 

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    const response = await fetch('contact_form.php', {
        method: 'POST',
        body: formData
    });

    let data;

    try {
        data = await response.json();
    } catch {
        alert("Server error");
        return;
    }

    form.querySelectorAll("input, textarea").forEach(field => {
        field.setCustomValidity("");
    });

    if (data.status === "error") {

        if (data.message.includes("required")) {
            if (form.first_name.value === "") form.first_name.setCustomValidity("First name is required");
            if (form.last_name.value === "") form.last_name.setCustomValidity("Last name is required");
            if (form.email.value === "") form.email.setCustomValidity("Email is required");
            if (form.message.value === "") form.message.setCustomValidity("Message is required");
        }

        if (data.message.includes("email")) {
            form.email.setCustomValidity("Please enter a valid email address");
        }

        if (data.message.includes("phone")) {
            form.phone.setCustomValidity("Please enter a valid phone number");
        }

        form.reportValidity();
        return;
    }

    if (data.status === "success") {
        alert("Message sent successfully!");
        form.reset();
    }
});

