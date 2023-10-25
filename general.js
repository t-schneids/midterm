window.onload = function() {
    const tabGroup = document.querySelector(".tabGroup");
    const tabs = document.querySelectorAll(".tabs");
    const hamburger = document.querySelector(".hamburger");
    const closeIcon = document.querySelector(".closeIcon");
    const menuIcon = document.querySelector(".menuIcon");
    const nav = document.querySelector(".nav");
    
    closeIcon.style.display = "none";

    function toggle() {
         if (tabGroup.classList.contains("showMenu")) {
            //close the menu
            tabGroup.classList.remove("showMenu");
            closeIcon.style.display = "none";
            menuIcon.style.display = "block";
        } else {
            //open the menu
            tabGroup.classList.add("showMenu");
            tabGroup.style.opacity = 1;
            closeIcon.style.display = "block";
            menuIcon.style.display = "none";
        }
    }
    
    // Make menu disappear
    hamburger.addEventListener("click", toggle);

    tabs.forEach(element => {
        element.addEventListener("click", toggle);
    });
}

