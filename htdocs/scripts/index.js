import { Endpoint } from "./endpoint.js";

const endpoint = new Endpoint();

async function getCountryList() {
  // Request the data
  let countryEndpoint = endpoint.for({});

  //   Fetch the data from the API.
  let response = await fetch(countryEndpoint);

  //   Parse the response as JSON.
  let countryList = await response.json();

  // Save the country list to local storage.
  localStorage.setItem("countryList", JSON.stringify(countryList));

  return countryList;
}

function displayCountries(countryList) {
  //   Select the div where the data will be displayed.
  let div = document.querySelector(".country_list");

  //   Loop through the data and display it as an accordion.
  for (let country of countryList.countries) {
    let details = document.createElement("details");
    let summary = document.createElement("summary");
    let p = document.createElement("p");

    summary.textContent = country.CountryName;
    summary.setAttribute("data-iso", country.ISO);

    details.append(summary);
    details.append(p);

    div.append(details);
  }
}

// Filter the countries
function filterCountries(search) {
  let currentCountryList = document.querySelector(".country_list");
  let searchValue = search.target.value.toLowerCase();

  console.log(searchValue);

  // Loop through the currentCountryList and hide the ones that don't match the search value.
  for (let country of currentCountryList.children) {
    if (
      !country.children[0].textContent.toLowerCase().startsWith(searchValue)
    ) {
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

  return cityList;
}

async function displayCities(event) {
  if (event.target.tagName !== "SUMMARY") {
    return;
  }

  // Get the ISO code from the clicked country.
  let iso = event.target.getAttribute("data-iso");

  // Get the cities from the API.
  let cities = await getCityList(iso);

  // Display the cities under the p element of the clicked country.
  let p = event.target.parentElement.children[1];

  let ul = document.createElement("ul");

  // Loop through the cities and display them.
  for (let city of cities.cities) {
    let li = document.createElement("li");
    li.textContent = city.CityName;
    ul.append(li);
  }

  p.append(ul);

  // If there are no cities, display a message.
  if (cities.cities.length === 0) {
    p.textContent = "No cities found.";
  }
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
let countryListDiv = document.querySelector(".country_list");
countryListDiv.addEventListener("click", displayCities);
