            </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="copyright">
                    <p>Copyright © <?= date('Y') ?> <?= $page['url_name'] ?>. All rights reserved.</p>
                </div>
            </div>

            </div>


            <!-- Mobile sticky footer -->
            <div class="sidebar-mobile-footer">
                <a href="dashboard.php" class="footer-item <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i><span>Home</span>
                </a>
                <a href="transactions.php" class="footer-item <?= ($current_page == 'transactions') ? 'active' : '' ?>">
                    <i class="fas fa-exchange-alt"></i><span>Transactions</span>
                </a>
                <a href="transfer.php" class="footer-item <?= ($current_page == 'transfer') ? 'active' : '' ?>">
                    <i class="fas fa-paper-plane"></i><span>Transfer</span>
                </a>
                <a href="card.php" class="footer-item <?= ($current_page == 'card') ? 'active' : '' ?>">
                    <i class="fas fa-credit-card"></i><span>Cards</span>
                </a>
                <a href="profile.php" class="footer-item <?= ($current_page == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user"></i><span>Profile</span>
                </a>
            </div>
            <!-- Scripts -->

            <script src="<?= $web_url ?>/user/assets/js/global.min.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/bootstrap-select.min.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/Chart.bundle.min.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/owl.carousel.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/jquery.peity.min.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/apexchart.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/dashboard-1.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/custom.min.js"> </script>
            <script src="<?= $web_url ?>/user/assets/js/theme-settings.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <?php echo $livechat; ?>

            <script>
function enforceOverlaySidebar() {
    if ($(window).width() <= 767) {
        $("body").attr("data-sidebar-style", "overlay");
    } else {
        // Optionally reset to user's saved preference on desktop
        $("body").attr("data-sidebar-style", $("body").data("saved-sidebar-style") || "full");
    }
}

$(document).ready(function() {
    // Save the original style for desktop
    $("body").data("saved-sidebar-style", $("body").attr("data-sidebar-style"));

    enforceOverlaySidebar();
    $(window).on("resize", enforceOverlaySidebar);
});
            </script>
            <script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('customDropdownTrigger');
    const menu = document.getElementById('customDropdownMenu');

    if (trigger && menu) {

        // Function to handle outside clicks and close the menu
        const outsideClickListener = function(event) {
            // If the click is not on the menu AND not on the trigger
            if (!menu.contains(event.target) && !trigger.contains(event.target)) {
                menu.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
                // Remove the listener once the menu is closed
                document.removeEventListener('click', outsideClickListener);
            }
        };

        // Click listener for the main trigger button
        trigger.addEventListener('click', function(event) {
            event.preventDefault(); // Stop the link from navigating (critical)

            // 1. Toggle the 'show' class to display/hide the menu
            menu.classList.toggle('show');

            // 2. Update ARIA attribute
            const isExpanded = menu.classList.contains('show');
            trigger.setAttribute('aria-expanded', isExpanded);

            // 3. Attach or detach the outside click handler
            if (isExpanded) {
                // Give a tiny delay to prevent the current click from immediately closing the menu
                setTimeout(() => {
                    document.addEventListener('click', outsideClickListener);
                }, 0);
            } else {
                document.removeEventListener('click', outsideClickListener);
            }
        });
    }
});
            </script>
            <script>
document.addEventListener("DOMContentLoaded", () => {
    const triggers = document.querySelectorAll(".benDropdownTrigger");

    triggers.forEach(trigger => {
        const menu = trigger.parentElement.querySelector(".benDropdownMenu");

        const outsideClickListener = (event) => {
            if (!menu.contains(event.target) && !trigger.contains(event.target)) {
                menu.classList.remove("show");
                trigger.setAttribute("aria-expanded", "false");
                document.removeEventListener("click", outsideClickListener);
            }
        };

        trigger.addEventListener("click", (event) => {
            event.preventDefault();

            // Close other dropdowns
            document.querySelectorAll(".benDropdownMenu.show").forEach(openMenu => {
                if (openMenu !== menu) openMenu.classList.remove("show");
            });

            menu.classList.toggle("show");
            const isOpen = menu.classList.contains("show");

            trigger.setAttribute("aria-expanded", isOpen);

            if (isOpen) {
                setTimeout(() => {
                    document.addEventListener("click", outsideClickListener);
                }, 0);
            } else {
                document.removeEventListener("click", outsideClickListener);
            }
        });
    });
});
            </script>




            <!-- Theme live preview (no cookies, no demo overrides) 
 <script src="https://mophy-python-django-payment-admin-dashboard-template.dexignzone.com/static/mophy/js/deznav-init.js"> </script>
<script src="https://mophy-python-django-payment-admin-dashboard-template.dexignzone.com/static/mophy/js/demo.js"> </script>
-->


            </body>

            </html>