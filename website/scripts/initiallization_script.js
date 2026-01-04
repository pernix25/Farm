// File Description:
// javascript code that just reads data from the database and 
// appends data to website at start

//=====================================================================
//                    get cow info from database
//=====================================================================
fetch("api/cows.php")
  .then(response => response.json())
  .then(data => {
    const cowList = document.getElementById("cow_list");
    const cowTotals = document.getElementById("cow_totals");
    cowList.innerHTML = ""; // clear existing items

    // Display counts by cow type
    const typeCounts = data.cow_types;
    for (const [type, total] of Object.entries(typeCounts)) {
        const li = document.createElement("li");
        li.textContent = `${type}s: ${total}`;
        cowTotals.appendChild(li);
    }

    // Display individual cows
    const cows = data.cows;
    cows.forEach(cow => {
        const li = document.createElement("li");
        li.textContent = `Cow #${cow.cow_id} (${cow.type_desc}) - Tags: ${cow.numbers || "N/A"}`;
        cowList.appendChild(li);
    });
  })
  .catch(err => {
      console.error("Error fetching cows:", err);
      const cowList = document.getElementById("cowList");
      cowList.innerHTML = "<li>Failed to load cows</li>";
  });



//=====================================================================
//               get medication info from database
//=====================================================================
fetch("api/medicine.php")
  .then(response => response.json())
  .then(data => {
    // dynamically creates default page for medicaitons
    const medicineList = document.getElementById("medicine_list");
    medicineList.innerHTML = ""; // clear existing items

    // Display individual medicines
    const medications = data.medications;
    medications.forEach(medication => {
        const li = document.createElement("li");
        li.textContent = medication.medication_name;
        medicineList.appendChild(li);
    });

    // dynamically creates the checkbox for cows page on administering medicine
    const box = document.getElementById("cow_medication_box");
    box.innerHTML = "";

    medications.forEach(med => {
        const label = document.createElement("label");

        const input = document.createElement("input");
        input.type = "checkbox";
        input.name = "medications[]";
        input.value = med.medication_name; // or med.medication_id

        label.appendChild(input);
        label.append(" " + med.medication_name);

        box.appendChild(label);
    });
  })
  .catch(err => {
      console.error("Error fetching medications:", err);
      const medicineList = document.getElementById("medicine_list");
      medicineList.innerHTML = "<li>Failed to load medications</li>";
  });
