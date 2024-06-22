const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();

const today = new Date(2024, 5, 8); // Date d'aujourd'hui fixée à 08 Juin 2024
const selectedDateElement = document.createElement("p");
selectedDateElement.classList.add("selected-date");
document.querySelector("#calendar_container").appendChild(selectedDateElement);

const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) {
        // Désactiver la date courante par défaut
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                     && currYear === new Date().getFullYear() ? "inactive" : "";

        let isPast = (currYear < today.getFullYear()) || 
                     (currYear === today.getFullYear() && currMonth < today.getMonth()) ||
                     (currYear === today.getFullYear() && currMonth === today.getMonth() && i < today.getDate()) ? "inactive" : "";

        liTag += `<li class="${isToday} ${isPast}">${i}</li>`;
    }

    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;

    // Ajouter un événement de clic aux jours actifs
    document.querySelectorAll(".days li:not(.inactive)").forEach(day => {
        day.addEventListener("click", () => {
            document.querySelectorAll(".days li").forEach(d => d.classList.remove("selected", "active"));
            day.classList.add("selected", "active");
            selectedDateElement.innerText = `Date sélectionnée : ${day.innerText} ${months[currMonth]} ${currYear}`;
            event.preventDefault(); // Supprimer la mise au point pour éviter le contour
        });
    });
}

renderCalendar();

prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        if(icon.id === "prev" && (currYear === today.getFullYear() && currMonth === today.getMonth())) {
            return;
        }

        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
        }

        if(currYear < today.getFullYear() || (currYear === today.getFullYear() && currMonth < today.getMonth())) {
            currYear = today.getFullYear();
            currMonth = today.getMonth();
        }

        renderCalendar();
    });
});
