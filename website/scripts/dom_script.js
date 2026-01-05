// File Description:
// javascript funcitons and event handlers that only manipulate the DOM w/out anything else

//=============================================================
//                      Functions
//=============================================================

//---------------------------------------------
//    hides/shows sections, pages, and navs
//---------------------------------------------
function showSection(id, section_class_name) {
    // set all seciton to display none
    document.querySelectorAll(`.${section_class_name}`).forEach(sec => {
        sec.style.display = "none";
    });

    // set the one sections display to block based on id
    document.getElementById(id).style.display = "block";
}

function showNav(id) {
    // set all seciton to display none
    document.querySelectorAll('.section_nav').forEach(sec => {
        sec.style.display = "none";
    });

    // set the one sections display to block based on id
    document.getElementById(id).style.display = "block";
}

function showPage(id){
    // set all pages to display none
    document.querySelectorAll('.page').forEach(sec => {
        sec.style.display = "none";
    });

    // set the one page to display block based on id
    document.getElementById(id).style.display = "block";

    // set block display for the page's nav -> hide the rest
    showNav(`${id}_nav`);

    // set block display for the page's default seciton -> hide the rest
    showSection(`${id}_default_tab`, `${id}_section`);
}



//=============================================================
//                       Cow Page
//=============================================================

//-----------------------
//        add cow
//-----------------------
document.getElementById("addCowNumberBtn").addEventListener("click", () => {
    const container = document.getElementById("cowNumbers");

    const input = document.createElement("input");
    input.type = "number";
    input.name = "cow_numbers[]";
    input.placeholder = "Cow number";

    container.appendChild(input);
});

//-----------------------
//     add baby cow
//-----------------------
document.getElementById("addBabyNumberBtn").addEventListener("click", () => {
    const container = document.getElementById("babyCowNumbers");

    // creates another cow number input element
    const cow_input = document.createElement("input");
    cow_input.type = "number";
    cow_input.name = "baby_cow_numbers[]";
    cow_input.placeholder = "Baby cow number";
    cow_input.required = true;

    //creates another cow type input element
    const newSelect = document.createElement("select");
    newSelect.name = "babyCowTypes[]"; // must match array name

    // Add options
    const options = ["Heifer", "Cow", "Bull", "Steer"];
    options.forEach(opt => {
        const option = document.createElement("option");
        option.value = opt;
        option.textContent = opt;
        if (opt === "Heifer") option.selected = true; // default selection
        newSelect.appendChild(option);
    });

    // create new div element to store both inputs
    const new_div = document.createElement("div");

    new_div.appendChild(cow_input);
    new_div.appendChild(newSelect);

    container.append(new_div)
});

//-----------------------
//     add sick cow
//-----------------------
document.getElementById("addSickCowNumberBtn").addEventListener("click", () => {
    const container = document.getElementById("sick_cow_numbers");

    const input = document.createElement("input");
    input.type = "number";
    input.name = "sick_cow_numbers[]";
    input.placeholder = "Sick cow number";

    container.appendChild(input);
});



//=============================================================
//                      Medicine Stuff
//=============================================================
