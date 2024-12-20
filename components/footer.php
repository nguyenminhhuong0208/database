<div class="top-footer">
    <h2><i class="bx bx-envelope"></i>Thanks for your support</h2>
    <div class="input-field">
        <input type="text" id="nameInput" placeholder="enter your name...">
        <button class="btn" id="donateButton">Subscribe</button>
    </div>
</div>
<footer>
    <div class="overlay"></div>
    <div class="footer-content">
        <div class="img-box">
            <img src="img/logo2.png">
        </div>
        <div class="inner-footer">
            <div class="card">
                <h3>service</h3>
                <ul>
                    <li>order</li>
                    <li>help center</li>
                    <li>shipping</li>
                    <li>term of use</li>
                    <li>account detail</li>
                    <li>my account</li>
                </ul>
            </div>
            <div class="card">
                <h3>newsletter</h3>
                <p>Sign up for Newlatter</p>
                <div class="social-link">
                    <i class="bx bxl-instagram"></i>
                    <i class="bx bxl-twitter"></i>
                    <i class="bx bxl-behance"></i>
                    <i class="bx bxl-youtube"></i>
                    <i class="bx bxl-whatsapp"></i>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <p>all right reserved - code with mySQL</p>
        </div>
        <div class="block-container" id="hiddenContent" style="display:none;">
            <label id="thanksLabel">Thanks for donate us</label>
            <div class="flex-box">
                <div class="block">
                    <img src="img/tuyenBank.jpg" class="image">
                    <label>tuyen</label>
                </div>
                <div class="block">
                    <img src="img/thuongBank.jpg" class="image">
                    <label>thuong</label>
                </div>
                <div class="block">
                    <img src="img/tuyenBank.jpg" class="image">
                    <label>huong</label>
                </div>
            </div>
        </div>
    </div>

    <script>
    const nameInput = document.getElementById('nameInput');
    const thanksLabel = document.getElementById('thanksLabel');

    function scrollPageDown() {
        const hiddenContent = document.getElementById('hiddenContent');
        if (hiddenContent.style.display === 'none') {
            hiddenContent.style.display = 'flex';
            thanksLabel.textContent = "Thank " + nameInput.value + " for donate us!" || "hehe";
        }

        hiddenContent.scrollIntoView({
            behavior: 'smooth'
        });
    }

    document.getElementById("donateButton").addEventListener("click", scrollPageDown);
    </script>

</footer>