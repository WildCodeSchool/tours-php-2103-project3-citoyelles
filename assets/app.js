/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

function openNav() {
    document.querySelector('nav.sidenav').style.width = '100%';
}

const burgerButton = document.getElementById('burger');
burgerButton.addEventListener('click', openNav);

function closeNav() {
    document.querySelector('nav.sidenav').style.width = '0';
}

const closeButton = document.querySelector('a.closebtn');
closeButton.addEventListener('click', closeNav);

// Top Button

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// Get the button
const mybutton = document.getElementById('myBtn');
mybutton.addEventListener('click', topFunction);

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = 'block';
    } else {
        mybutton.style.display = 'none';
    }
}
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = () => scrollFunction();
