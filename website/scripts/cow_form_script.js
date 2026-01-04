// file description
// javacript that handles the cow page forms that interact with the database

//===================================================================================================
//                                      Add Cow Form
//===================================================================================================
document.getElementById("add_cow_form").addEventListener("submit", (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("api/add_cow.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert(`Cow added with ${data.count} number(s)!`);

            form.reset();

            // reset the number of cow numbers being added to 1
            document.getElementById("cowNumbers").innerHTML =
                `<input type="number" name="cow_numbers[]" placeholder="Cow number" required>`;
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(err => console.error(err));
});

//===================================================================================================
//                                    Add Baby Cow Form
//===================================================================================================
document.getElementById("add_baby_form").addEventListener("submit", (e) => {
    e.preventDefault(); // prevent page reload

    const form = e.target;
    const formData = new FormData(form);

    fetch("api/add_babies.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert(`Added ${data.count} baby cows successfully!`);
            form.reset();

            // Reset the first baby input + type
            document.getElementById("babyCowNumbers").innerHTML = `
                <div>
                    <input type="number" name="babyCowNumbers[]" placeholder="Baby cow number" required>
                    <select name="babyCowTypes[]">
                        <option value="Heifer" selected>Heifer</option>
                        <option value="Cow">Cow</option>
                        <option value="Bull">Bull</option>
                        <option value="Steer">Steer</option>
                    </select>
                </div>
            `;
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error(err));
});

//===================================================================================================
//                                    Add Cow Tag Form
//===================================================================================================
document.getElementById("add_tag_form").addEventListener("submit", (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("api/add_tag.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Successfully added tag to cow");

            form.reset();
        } else {
            alert("Error " + data.message);
        }
    })
    .catch(err => console.error(err));
});
