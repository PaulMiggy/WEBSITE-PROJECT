    <?php
    // Get selected package from the URL if available
    $selectedPackage = isset($_GET['package']) ? htmlspecialchars($_GET['package']) : '';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Your Trip | Rebooktel</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="style.css">
        <script>
        document.addEventListener("DOMContentLoaded", () => {
        // AJAX form submission
        const form = document.querySelector("form[name='bookingForm']");
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            // Create a new FormData object (this includes all input fields)
            const formData = new FormData(form);

            // Create a new AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "bookform.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Check for successful response
                    if (response.success) {
                        // Display booking confirmation and schedule
                        document.getElementById("responseContainer").innerHTML = `
                            <h2>Booking Confirmed!</h2>
                            <p><strong>Name:</strong> ${response.name}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Phone:</strong> ${response.phone}</p>
                            <p><strong>Package:</strong> ${response.package}</p>
                            <p><strong>Location:</strong> ${response.location}</p>
                            <p><strong>Guests:</strong> ${response.guest}</p>
                            <p><strong>Arrival:</strong> ${response.arrival}</p>
                            <p><strong>Departure:</strong> ${response.departure}</p>
                            <h3>Schedule of Activities:</h3>
                            <ul>${response.schedule.map(activity => `<li>${activity}</li>`).join('')}</ul>
                        `;
                        form.reset();
                    } else {
                        document.getElementById("responseContainer").innerHTML = `<p>Error: ${response.error}</p>`;
                    }
                }
            };

                // Send form data
                xhr.send(formData);
            });

            // Packages and Locations
            const packages = {
                "Cultural Immersion": ["Vigan City", "Intramuros", "Batanes"],
                "Beach Getaway": ["Boracay", "Palawan", "Siargao"],
                "Wellness Retreat": ["Baguio", "Dumaguete"],
                "Adventure Tour": ["Mount Apo", "Chocolate Hills"],
                "Island Hopping": ["Cebu", "Coron"],
                "Food Tour": ["Binondo", "Cebu"],
                "Historical Tour": ["Intramuros", "Vigan"],
                "Staycation Package": ["Tagaytay", "Baguio"]
            };

            function updateLocations() {
                const packageSelect = document.getElementById('packageSelect');
                const locationSelect = document.getElementById('locationSelect');
                const selectedPackage = packageSelect.value;

                // Clear previous locations
                locationSelect.innerHTML = '<option value="">Select Location</option>';

                // Add new locations based on selected package
                if (selectedPackage in packages) {
                    packages[selectedPackage].forEach(location => {
                        const option = document.createElement('option');
                        option.value = location;
                        option.textContent = location;
                        locationSelect.appendChild(option);
                    });
                }
            }

            document.getElementById("packageSelect").addEventListener("change", updateLocations);
            updateLocations(); // Initial load in case package is pre-selected

            // Date validation
            const arrivalDate = document.getElementById("arrivalDate");
            const departureDate = document.getElementById("departureDate");

            arrivalDate.addEventListener("change", () => {
                departureDate.min = arrivalDate.value;
            });
        });
        </script>
    </head>
    <body>
    <section class="header">
        <a href="website1.php" class="logo">Rebooktel</a>
        <nav class="navbar">
            <a href="Website1.php">Home</a>
            <a href="About.php">About</a>
            <a href="Packages.php">Packages</a>
            <a href="Book.php">Book</a>
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>
    </section>

    <div class="heading" style="background:url(Picture/Header/B.jpg) no-repeat">
        <h1>Book now</h1>
    </div>

    <section class="booking">
        <h1 class="heading-title">Book Your Trip!</h1>
        <form name="bookingForm" method="post" class="book-form">
            <div class="flex">
                <div class="inputBox">
                    <span>Name:</span>
                    <input type="text" placeholder="Enter your name" name="name" required>
                </div>

                <div class="inputBox">
                    <span>Email:</span>
                    <input type="email" placeholder="Enter your email" name="email" required>
                </div>

                <div class="inputBox">
                    <span>Contact No:</span>
                    <input type="tel" placeholder="Enter your phone" name="phone" pattern="[0-9]{11,}" required>
                    <small>Format: 11 digits or more (e.g., 09123456789)</small>
                </div>

                <div class="inputBox">
                    <span>Address:</span>
                    <input type="text" placeholder="Enter your address" name="address" required>
                </div>

                <div class="inputBox">
                    <span>Package:</span>
                    <select name="package" id="packageSelect" required>
                        <option value="">Select Package</option>
                        <option value="Cultural Immersion" <?php if ($selectedPackage == 'Cultural Immersion') echo 'selected'; ?>>Cultural Immersion</option>
                        <option value="Beach Getaway" <?php if ($selectedPackage == 'Beach Getaway') echo 'selected'; ?>>Beach Getaway</option>
                        <option value="Wellness Retreat" <?php if ($selectedPackage == 'Wellness Retreat') echo 'selected'; ?>>Wellness Retreat</option>
                        <option value="Adventure Tour" <?php if ($selectedPackage == 'Adventure Tour') echo 'selected'; ?>>Adventure Tour</option>
                        <option value="Island Hopping" <?php if ($selectedPackage == 'Island Hopping') echo 'selected'; ?>>Island Hopping</option>
                        <option value="Food Tour" <?php if ($selectedPackage == 'Food Tour') echo 'selected'; ?>>Food Tour</option>
                        <option value="Historical Tour" <?php if ($selectedPackage == 'Historical Tour') echo 'selected'; ?>>Historical Tour</option>
                        <option value="Staycation Package" <?php if ($selectedPackage == 'Staycation Package') echo 'selected'; ?>>Staycation Package</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Location:</span>
                    <select name="location" id="locationSelect" required>
                        <option value="">Select Location</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Number of Days:</span>
                    <select name="duration" id="durationSelect" required>
                        <option value="3">3 Days</option>
                        <option value="4">4 Days</option>
                        <option value="5">5 Days</option>
                        <option value="6">6 Days</option>
                        <option value="7">7 Days</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Number of Guests:</span>
                    <input type="number" name="guest" min="1" max="10" placeholder="Enter number of guests" required>
                </div>

                <div class="inputBox">
                    <span>Arrival Date:</span>
                    <input type="date" name="arrival" id="arrivalDate" required>
                </div>

                <div class="inputBox">
                    <span>Departure Date:</span>
                    <input type="date" name="departure" id="departureDate" required>
                </div>
            </div>
            <input type="submit" value="Book Now" class="btn">
        </form>

        <div id="responseContainer"></div> <!-- Response Container for AJAX -->
    </section>

        <section class="footer">    
        <div class="box-container">
        <div class="box">
            <h3>Quick Links</h3>
            <a href="Website1.php"><i class="fas fa-angle-right"></i>home</a >
            <a href="About.php"><i class="fas fa-angle-right"></i>about</a >
            <a href="Packages.php"><i class="fas fa-angle-right"></i>packages</a >
            <a href="Book.php"><i class="fas fa-angle-right"></i>book</a >

        </div>

        <div class="box">
            <h3>Extra Links</h3>
            <a href="About.php"><i class="fas fa-angle-right"></i>about us</a >
            <a href="Privacy-Policy.php"><i class="fas fa-angle-right"></i>privacy policy</a >
            <a href="Term-use.php"><i class="fas fa-angle-right"></i>terms of use</a >
            <a href="tel:+639955583001"><i class="fas fa-angle-right"></i>contact us</a >


        </div>
        <div class="box">
            <h3>contact info</h3>
            <a href="tel:+639955583001"><i class="fas fa-phone"></i>+63995-558-3001</a >
            <a href="tel:+639955583001"><i class="fas fa-phone"></i>+63995-558-3001</a >
            <a href="mailto:gabxdedma@gmail.com"><i class="fas fa-envelope"></i>gabxdedma@gmail.com</a >
            <a href="https://maps.app.goo.gl/cuvx6H1tYw2Eht4k7" target="_blank"><i class="fas fa-map"></i>Muntinlupa, 1772 Metro Manila</a >
        </div>
        <div class="box">
            <h3>follow us</h3>
            <a href="#"><i class="fab fa-facebook-f"></i>facebook</a >
            <a href="#"><i class="fab fa-github"></i>github</a >
            <a href="#"><i class="fab fa-instagram"></i>instagram</a >
            <a href="#"><i class="fab fa-linkedin"></i>Linkedin</a >
            


        </div>
        </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="script1.js">
        </script>
        </body>
        </html>