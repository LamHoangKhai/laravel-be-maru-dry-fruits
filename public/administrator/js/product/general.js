$(document).ready(() => {
    let multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
        maxItemCount: 20,
        renderChoiceLimit: 20,
    });

    $("#description").summernote({
        placeholder: "Enter description",
        tabsize: 4,
        height: 160,
    });

    $("#nutrition_detail").summernote({
        placeholder: "Enter nutrition detail",
        tabsize: 4,
        height: 160,
    });
    $("#customFile1").change((e) => {
        displaySelectedImage(e, "selectedImage");
    });

    function displaySelectedImage(event, elementId) {
        const selectedImage = document.getElementById(elementId);
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                selectedImage.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
});
