document.addEventListener("DOMContentLoaded", () => {
    console.log("%cSimple Blog System Demo5 ready - All features loaded", "color:green;font-weight:bold");
    // Client-side form validation
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", e => {
            if (!form.checkValidity()) { e.preventDefault(); alert("Please fill all required fields correctly."); }
        });
    });
});
