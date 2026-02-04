
<!-- Social Section Starts Here -->
<section class="social">
    <div class="container text-center">
        <ul>
            <li>
                <a href="#" title="Facebook">
                    <img src="https://img.icons8.com/fluent/48/000000/facebook-new.png" alt="Facebook" />
                </a>
            </li>
            <li>
                <a href="#" title="Instagram">
                    <img src="https://img.icons8.com/fluent/48/000000/instagram-new.png" alt="Instagram" />
                </a>
            </li>
            <li>
                <a href="#" title="Twitter">
                    <img src="https://img.icons8.com/fluent/48/000000/twitter.png" alt="Twitter" />
                </a>
            </li>
        </ul>
    </div>
</section>
<!-- Social Section Ends Here -->

<!-- Footer Section Starts Here -->
<section class="footer">
    <div class="container text-center">
        <p>
            &copy; <span id="year"></span> All rights reserved. Designed by 
            <a href="#" target="_blank">Group_One Student @WCU</a>
        </p>
    </div>
</section>
<!-- Footer Section Ends Here -->

<!-- Add Dark Mode Script -->
<!-- Consolidated Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Dark Mode Functionality ---
        const body = document.body;
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const darkModeIcon = darkModeToggle ? darkModeToggle.querySelector('i') : null;
        const darkClass = 'dark-mode';
        const storageKey = 'darkMode';

        const applyTheme = (theme) => {
            if (theme === 'on') {
                body.classList.add(darkClass);
                if (darkModeIcon) {
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                }
            } else {
                body.classList.remove(darkClass);
                if (darkModeIcon) {
                    darkModeIcon.classList.remove('fa-sun');
                    darkModeIcon.classList.add('fa-moon');
                }
            }
        };

        const handleToggleClick = () => {
            const isDarkMode = body.classList.contains(darkClass);
            if (isDarkMode) {
                localStorage.setItem(storageKey, 'off');
                applyTheme('off');
            } else {
                localStorage.setItem(storageKey, 'on');
                applyTheme('on');
            }
        };

        if (darkModeToggle && darkModeIcon) {
            darkModeToggle.addEventListener('click', handleToggleClick);
        }

        const currentTheme = localStorage.getItem(storageKey);
        applyTheme(currentTheme);

        // --- Burger Menu Functionality ---
        const burger = document.querySelector('.burger');
        // ***** CHECK THIS SELECTOR *****
        // Does your menu container have class="menu" and contain a UL?
        // If not, adjust '.menu ul' accordingly. Maybe it's just '.menu' or '#nav-menu ul'?
        const menu = document.querySelector('.menu ul'); // <--- COMMON POINT OF FAILURE

        // Check if elements were found before adding listener
        if (burger && menu) {
            console.log("Burger and Menu elements found. Adding listener."); // Debugging log
            burger.addEventListener('click', function() {
                console.log("Burger clicked!"); // Debugging log
                menu.classList.toggle('active'); // Toggles visibility (needs CSS)
                burger.classList.toggle('toggle'); // Toggles burger animation (needs CSS)
            });
        } else {
            // Log errors if elements are not found
            if (!burger) console.error("Burger element (.burger) not found!");
            if (!menu) console.error("Menu element (.menu ul) not found!");
        }

        // --- Dynamic Year ---
        const yearSpan = document.getElementById('year');
        if (yearSpan) {
            yearSpan.textContent = new Date().getFullYear();
        }

    }); // End DOMContentLoaded
</script>

</body>
</html>