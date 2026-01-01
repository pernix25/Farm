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

  
