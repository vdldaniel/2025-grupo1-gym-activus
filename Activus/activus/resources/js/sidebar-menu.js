const menu = document.getElementById("menu"); 
const sidebar = document.getElementById("sidebar");
const main = document.getElementById("main");

if (window.innerWidth <= 500) {
    sidebar.classList.remove("menu-toggle");
}

menu.addEventListener("click", ()=>{
    sidebar.classList.toggle("menu-toggle");
    menu.classList.toggle("menu-toggle");
    main.classList.toggle("menu-toggle");
    
});
