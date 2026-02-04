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
            &copy; <span id="year"></span> Cosmetic Brand Dashboard. Managed by 
            <a href="#" target="_blank">Group_One Student @WCU</a>
        </p>
    </div>
</section>
<!-- Footer Section Ends Here -->

<!-- JavaScript for Features -->
<script>
    // Toggle Dark Mode
    function toggleDarkMode() {
        const body = document.getElementById('body');
        const darkClass = 'dark-mode';

        if (body.classList.contains(darkClass)) {
            body.classList.remove(darkClass);
            localStorage.setItem('darkMode', 'off');
        } else {
            body.classList.add(darkClass);
            localStorage.setItem('darkMode', 'on');
        }

        const icon = document.querySelector('.dark-mode-toggle i');
        icon.classList.toggle('fa-sun');
        icon.classList.toggle('fa-moon');
    }

    // Set Dark Mode Based on Preference
    window.onload = function () {
        const darkModeSetting = localStorage.getItem('darkMode');
        if (darkModeSetting === 'on') {
            document.getElementById('body').classList.add('dark-mode');
        }
        // Set the footer year dynamically
        document.getElementById('year').textContent = new Date().getFullYear();
    };

    // Responsive Burger Menu Toggle
   
    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.querySelector('.burger');
        
        // Select the container DIV, not the UL inside it
const menuContainer = document.querySelector('.menu');

        // Check if both elements were found
        if (burger && menuContainer) {
            console.log("Burger and Menu elements found. Adding listener."); // Debugging log

            burger.addEventListener('click', function() {
                
            console.log("Burger clicked!"); // Debugging log

                // Toggle the 'active' class on the menu container DIV
                menuContainer.classList.toggle('active');

                // Toggle the animation class on the burger icon itself
                burger.classList.toggle('toggle');
            });
        } else {
            // Log an error if elements aren't found - helps debugging
            if (!burger) console.error("Burger element (.burger) not found!");
            if (!menuContainer) console.error("Menu container element (.menu ul) not found!");
        }
    });

    
</script>
</body>
</html>
