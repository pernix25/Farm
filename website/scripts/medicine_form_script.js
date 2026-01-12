// file description
// javacript that handles the medicine page forms that interact with the database

//===================================================================================================
//                                    Add Medicine Form
//===================================================================================================
document.getElementById("add_medicine_form").addEventListener("submit", (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("api/medicine_php/add_medicine.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Medication successfully added")

            form.reset();
        } else {
            alert("Error " + data.error)
        }
    })
    .catch(err => console.error(err));
});