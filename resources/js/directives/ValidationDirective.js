export const validationDirective = {
    inserted: function (el, binding) {
        main(el, binding)
    },
    update: function (el, binding) {
        main(el, binding)
    }
}

function main(el, binding) {
    const isCustomMessage = binding.value[1] !== "" && binding.value[1] !== null;
    const init = binding.value[0];

    if (!init.rule || isCustomMessage)
    {
        if (!el.classList.contains("is-invalid"))
        {
            el.classList.add("is-invalid");

            const message = isCustomMessage ? binding.value[1][0] : init.message;

            let errorMessage = document.createElement('div');
            errorMessage.classList.add("invalid-feedback");
            errorMessage.innerHTML = message;
            el.parentNode.appendChild(errorMessage);
        }

    } else {

        if (el.classList.contains("is-invalid"))
        {
            el.classList.remove("is-invalid");
            el.parentNode.querySelectorAll('.invalid-feedback')[0].remove();
        }
    }
}
