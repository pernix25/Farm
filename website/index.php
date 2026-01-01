<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device_width, initial_scale=1.0">
    <title>Cow Database</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Cows Incorporated</h1>

    <nav class="navbar">
        <ul>
            <li><button onclick="showPage('cow')">Cows</button></li>
            <li><button onclick="showPage('medicine')">Medications</button></li>
            <li><button onclick="showPage('auction')">Auction</button></li>
            <li><button onclick="showPage('dashboard')">Dashboard</button></li>
            <li><button onclick="showPage('Missellaneous')">Missellaneous</button></li>
        </ul>
    </nav>

    <!---------------------------------------------------->
    <!--                 cow section                    -->
    <!---------------------------------------------------->
    <div id="cow" class="page">
        <nav id="cow_nav" class="navbar nav_section">
            <ul>
                <li><button onclick="showSection('add_cow_tab', 'cow_section')">Add Cow</button></li>
                <li><button onclick="showSection('baby_tab', 'cow_section')">Add Baby</button></li>
                <li><button onclick="showSection('delete_tab', 'cow_section')">Delete Cow</button></li>
                <li><button onclick="showSection('tag_tab', 'cow_section')">Add Tag</button></li>
                <li><button onclick="showSection('medicate_tab', 'cow_section')">Medicate</button></li>
                <li><button onclick="showSection('notes_tab', 'cow_section')">Add Note</button></li>
            </ul>
        </nav>
        <div id="cow_body" class="section_body">
            <div id="cow_default_tab" class="cow_section">
                <ul id="cow_totals"></ul>
                <ul id="cow_list"></ul>
            </div>

            <!-------------------------->
            <!--     add cow page     -->
            <!-------------------------->
            <div id="add_cow_tab" class="cow_section">
                <h3>Add New Cows</h3>
                <form>
                    <div>
                        <label for="cowType">Cow Type:</label>
                        <select id="cowType" name="cowType">
                            <option value="Heifer">Heifer</option>
                            <option value="Cow">Cow</option>
                            <option value="Bull">Bull</option>
                            <option value="Steer">Steer</option>
                        </select>
                    </div>

                    <div>
                        <div id="cowNumbers">
                            <input type="number" name="cow_numbers[]" placeholder="Cow number">
                        </div>
                        <button type="button" id="addCowNumberBtn">Add another number</button>
                    </div>

                    <div>
                        <label for="">Date Added:</label>
                        <input type="date" id="birthDate" name="birthDate">
                    </div>

                    <button type="submit">Add Cow</button>
                </form>
            </div>

            <!-------------------------->
            <!--    add baby page     -->
            <!-------------------------->
            <div id="baby_tab" class="cow_section">
                <h3>Add Baby Cow</h3>
                <form>
                    <div>
                        <label for="mamaCowNumber">Mama Cow Number:</label>
                        <input type="number" id="mamaCowNumber" name="mamaCowNumber" min="1" max="999">
                    </div>
                    <div>
                        <div id="babyCowNumbers">
                            <input type="number" name="baby_cow_numbers[]" placeholder="Baby cow number">
                        </div>
                        <button type="button" id="addBabyNumberBtn">Add another baby number</button>
                    </div>

                    <button type="submit">Add Babies</button>
                </form>
            </div>

            <!-------------------------->
            <!--   delete cow page    -->
            <!-------------------------->
            <div id="delete_tab" class="cow_section">
                <h3>Delete Cow</h3>
                    <form>
                        <div>
                            <label for="deleteCowNumber">Cow number to be deleted:</label>
                            <input type="number" id="deleteCowNumber" name="deleteCowNumber" min="1" max="999">
                        </div>

                        <button type="submit">Delete Cow</button>
                    </form>
            </div>

            <!-------------------------->
            <!--     add tag page     -->
            <!-------------------------->
            <div id="tag_tab" class="cow_section">
                <h3>Add Tag to Cow</h3>
                    <form>
                        <div>
                            <label for="OldTagNumber">Old Tag Number:</label>
                            <input type="number" id="OldTagNumber" name="OldTagNumber" min="1" max="999">
                        </div>

                        <div>
                            <label for="NewTagNumber">New Tag Number:</label>
                            <input type="number" id="NewTagNumber" name="NewTagNumber" min="1" max="999">
                        </div>

                        <button type="submit">Tag Cow</button>
                    </form>
            </div>

            <!-------------------------->
            <!--    medicate page     -->
            <!-------------------------->
            <div id="medicate_tab" class="cow_section">
                <h3>Administer Medicine to Cow</h3>
                    <form>
                        <div>
                            <!--  make a drop down menu of all medicaitons -->
                            <label for="medicationName">Medication:</label>
                            <input type="text" id="medicationName" name="medicationName">
                            <!----------------------------------------------->
                        </div>

                        <div>
                            <div id="sickCowNumbers">
                                <input type="number" name="sick_cow_numbers[]" placeholder="Sick cow number">
                            </div>
                            <button type="button" id="addSickCowNumberBtn">Add another sick number</button>
                        </div>

                        <button type="submit">Medicate Cows</button>
                    </form>
            </div>

            <!-------------------------->
            <!--    add note page     -->
            <!-------------------------->
            <div id="notes_tab" class="cow_section">
                <h3>Additional Notes</h3>
                <form>
                    <div>
                        <label for="addNote">Add Note:</label>
                        <input type="text" id="addNote" name="addNote">
                    </div>

                    <button type="submit">Add Note</button>
                </form>
            </div>
        </div>
    </div>

    <!---------------------------------------------------->
    <!--               medicine section                 -->
    <!---------------------------------------------------->
    <div id="medicine" class="page">
        <nav id="medicine_nav" class="navbar">
            <ul>
                <li><button>Add Medication</button></li>
                <li><button>Delete Medication</button></li>
            </ul>
        </nav>
        <div id="medicine_body" class="section_body">
            <p>Medicine main body</p>
        </div>
    </div>

    <!---------------------------------------------------->
    <!--                auction section                 -->
    <!---------------------------------------------------->
    <div id="auction" class="page">
        <nav id="auction_nav" class="navbar">
            <ul>
                <li><button>Bought Cows</button></li>
                <li><button>Sold Cows</button></li>
            </ul>
        </nav>
        <div id="auction_body" class="section_body">
            <p>Auction main body</p>
        </div>
    </div>

    <script src="scripts/php_script.js"></script>
    <script src="scripts/dom_script.js"></script>
</body>
</html>
