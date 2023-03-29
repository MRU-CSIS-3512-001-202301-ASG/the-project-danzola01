import { Endpoint } from "./endpoint.js";

const endpoint = new Endpoint();

async function getCountryList() {
  // Request the data
  let countryEndpoint = endpoint.for({});

  //   Fetch the data from the API.
  let response = await fetch(countryEndpoint);

  //   Parse the response as JSON.
  let countryList = await response.json();
  console.log(countryList);

  // Save the country list to local storage.
  localStorage.setItem("countryList", JSON.stringify(countryList));

  return countryList;
}

function displayCountries(countryList) {
  //   Select the div where the data will be displayed.
  let div = document.querySelector(".country_list");
  let ul = document.createElement("ul");
  ul.classList.add("ul_country");

  //   Loop through the data and display it as an accordion.
  for (let country of countryList.countries) {
    let li = document.createElement("li");
    // let hrAsLi = document.createElement("li");
    let hr = document.createElement("hr");
    hr.classList.add("hrAsLi");

    li.textContent = country.CountryName;
    li.setAttribute("data-iso", country.ISO);
    li.classList.add("li_country");
    // hrAsLi.classList.add("li_country");

    li.append(hr);

    ul.append(li);
    // ul.append(hrAsLi);
  }
  div.append(ul);
}

// Filter the countries
function filterCountries(search) {
  let currentCountryList = document.querySelector(".ul_country");
  let searchValue = search.target.value.toLowerCase();

  // Loop through the currentCountryList and hide the ones that don't match the search value.
  for (let country of currentCountryList.children) {
    if (country.textContent.toLowerCase().startsWith(searchValue)) {
      country.style.display = "block";
    } else {
      country.style.display = "none";
    }
  }

  // If the search value is empty, display all the countries.
  if (searchValue === "") {
    for (let country of currentCountryList.children) {
      country.style.display = "block";
    }
  }
}

async function getCityList(iso) {
  // Request the data
  let cityEndpoint = endpoint.for({ iso: iso });

  //   Fetch the data from the API.
  let response = await fetch(cityEndpoint);

  //   Parse the response as JSON.
  let cityList = await response.json();

  console.log(cityList);

  return cityList;
}

async function displayCities(event) {
  if (event.target.tagName !== "LI") {
    return;
  }

  let country = event.target.textContent;
  let title = document.querySelector("#city_title");

  // Display the country name in the title.
  title.textContent = "Cities in " + country;

  // Get the ISO code from the clicked country.
  let iso = event.target.getAttribute("data-iso");

  // Get the cities from the API.
  let cities = await getCityList(iso);

  // unhide the city list
  let cityList = document.querySelector("#city_list");
  cityList.classList.remove("hidden");

  // Select the div where the data will be displayed.
  let div = document.querySelector(".city_list");
  let ul = document.createElement("ul");

  // Clear the div before displaying the cities.
  div.replaceChildren();

  // Loop through the cities and display them.
  for (let city of cities.cities) {
    let li = document.createElement("li");
    li.textContent = city.CityName;
    ul.append(li);
  }

  // If there are no cities, display a message.
  if (cities.cities.length === 0) {
    let li = document.createElement("li");
    li.textContent = "No cities found.";
    ul.append(li);
  }

  div.append(ul);
}

// Check if the country list is in local storage.
if (localStorage.getItem("countryList")) {
  // If it is, display the countries.
  let countryList = JSON.parse(localStorage.getItem("countryList"));
  displayCountries(countryList);
} else {
  // If it isn't, get the country list from the API.
  let countryList = await getCountryList();
  displayCountries(countryList);
}

// Set a listener on the search input.
let search = document.querySelector("#country_search");

// When the user types in the search input, display the results.
search.addEventListener("keyup", filterCountries);

// When the user clicks on a country, display the cities.
let currentCountryList = document.querySelector(".ul_country");
currentCountryList.addEventListener("click", displayCities);
