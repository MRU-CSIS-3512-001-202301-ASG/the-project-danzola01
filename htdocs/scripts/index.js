// Imports
import { Endpoint } from "./endpoint.js";

// Initialize the endpoint
const endpoint = new Endpoint();

// Select the div where the data will be displayed.
let div = document.querySelector("#country_list");

async function getCountryList() {
  // Create the endpoint
  let countryEndpoint = endpoint.for({});

  // Fetch the data from the API.
  let response = await fetch(countryEndpoint);

  // Parse the response as JSON.
  let countryList = await response.json();

  // Save the country list to local storage.
  localStorage.setItem("countryList", JSON.stringify(countryList));

  return countryList;
}

async function getCityList(iso) {
  // Create the endpoint
  let cityEndpoint = endpoint.for({ iso: iso });

  // Fetch the data from the API.
  let response = await fetch(cityEndpoint);

  // Parse the response as JSON.
  let cityList = await response.json();

  return cityList;
}

async function getCountryInfo(iso) {
  // Create the endpoint
  let countryInfoEndpoint = endpoint.for({ infoISO: iso });

  // Fetch the data from the API.
  let response = await fetch(countryInfoEndpoint);

  // Parse the response as JSON.
  let countryInfo = await response.json();

  return countryInfo;
}

function displayCountries(countryList) {
  // Clear any existing data.
  div.replaceChildren();

  // Loop through the data and display it as an accordion.
  for (let country of countryList.countries) {
    // Create the elements that will be used to display the data.
    let details = document.createElement("details");
    let summary = document.createElement("summary");

    // Add the necessary data to the Summary element.
    summary.textContent = country.CountryName;
    summary.setAttribute("data-iso", country.ISO);

    // Append the accordion to the div.
    details.append(summary);
    div.append(details);
  }
}

function filterCountries(search) {
  // Get the current country list and the search value.
  let currentCountryList = document.querySelector("#country_list");
  let searchValue = search.target.value.toLowerCase();

  // Loop through the country list and remove the countries that don't match the search value.
  for (let country of currentCountryList.children) {
    if (!country.textContent.toLowerCase().startsWith(searchValue)) {
      country.style.display = "none";
    } else {
      country.style.display = "block";
    }
  }

  // If the search value is empty, display all the countries.
  if (searchValue === "") {
    for (let country of currentCountryList.children) {
      country.style.display = "block";
    }
  }
}

async function handleCountryClick(event) {
  // Handle the click event on the summary element (Country Name).
  if (event.target.nodeName === "SUMMARY") {
    // Display country info and city list.
    displayCountryInfo(event);
    displayCities(event);
  }
}

async function displayCountryInfo(event) {
  // Get the ISO code from the summary.
  let iso = event.target.getAttribute("data-iso");

  // Get the country info from the API.
  let countryInfo = await getCountryInfo(iso);
  countryInfo = countryInfo.country_information[0];

  // Select where the data will be displayed.
  let countryInfoArticle = document.querySelector("#country_info");

  // Clear the country info
  countryInfoArticle.replaceChildren();

  // Create the content that will go in the header of the article.
  let header = document.createElement("header");
  let img = document.createElement("img");

  // TODO - Add the image (placeholder for now)
  img.src =
    "https://res.cloudinary.com/dqg3qyjio/image/upload/v1674841639/3512-2023-01-project-images/48847889748.jpg";

  header.append(img);

  // Create the content that will go in the main of the article.
  let hgroup = document.createElement("hgroup");
  let h2 = document.createElement("h2");
  let h3 = document.createElement("h3");
  let description = document.createElement("p");

  // Set the content of the main.
  h2.textContent = countryInfo.CountryName;
  h3.textContent = countryInfo.Capital;
  description.textContent = countryInfo.Description;

  // Append the content to the main.
  hgroup.append(h2, h3);

  // Create the content that will go in the footer of the article.
  let footer = document.createElement("footer");
  let languages = document.createElement("p");
  let area = document.createElement("p");
  let population = document.createElement("p");
  let currency = document.createElement("p");
  let neighbours = document.createElement("p");
  let domain = document.createElement("p");

  // Format the data.
  countryInfo.Area = parseInt(countryInfo.Area).toLocaleString();
  countryInfo.Population = parseInt(countryInfo.Population).toLocaleString();

  // Set the content of the footer.
  languages.textContent = `Languages: ${countryInfo.Languages}`;
  area.textContent = `Area: ${countryInfo.Area} km²`;
  population.textContent = `Population: ${countryInfo.Population} million`;
  currency.textContent = `Currency: ${countryInfo.Currency}`;
  neighbours.textContent = `Neighbours: ${countryInfo.Neighbours}`;
  domain.textContent = `Domain: ${countryInfo.Domain}`;

  // Append the content to the footer.
  footer.append(languages, area, population, currency, neighbours, domain);

  // Append the content to the article.
  countryInfoArticle.append(header, hgroup, description, footer);

  // Display the article.
  countryInfoArticle.style.display = "block";

  // Get the height of the article.
  let articleHeight =
    header.offsetHeight +
    hgroup.offsetHeight +
    description.offsetHeight +
    footer.offsetHeight;

  // Set the height of the country list
  div.style.height = articleHeight + "px";

  // Scroll to the article.
  countryInfoArticle.scrollIntoView();
}

async function displayCities(event) {
  // Get the ISO code from the summary.
  let iso = event.target.getAttribute("data-iso");

  // Get the city list from the API.
  let cityList = await getCityList(iso);

  // Select the accordion where the data will be displayed.
  let accordion = event.target.parentElement;

  // Create a list to display the cities.
  let cityListElement = document.createElement("ul");

  // Loop through the city list and display the cities.
  for (let city of cityList.cities) {
    let li = document.createElement("li");
    li.textContent = city.CityName;
    cityListElement.append(li);
  }

  // If there are no cities, display a message.
  if (cityList.cities.length === 0) {
    let li = document.createElement("li");
    li.textContent = "No cities found.";
    cityListElement.append(li);
  }

  // Append the city list to the accordion.
  accordion.append(cityListElement);
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

// Filter the countries when the user types in the search box.
let search = document.querySelector("#country_search");
search.addEventListener("keyup", filterCountries);

// Call the handleCountryClick function when a summary is clicked.
let currentCountryList = document.querySelector("#country_list");
currentCountryList.addEventListener("click", handleCountryClick);
