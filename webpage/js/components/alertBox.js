export function alertBox(message) {
    let box = $("<div>").addClass("alert alert-danger w-100 text-center").text(message);

    return box;
}