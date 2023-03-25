import { Endpoint } from "./endpoint.js";

const endpoint = new Endpoint();

async function listAllCountries() {
  // Request the data
  let request = endpoint.for({});

  //   Fetch the data from the API.
  let response = await fetch(request);

  //   Parse the response as JSON.
  let data = await response.json();

  //   Select the div where the data will be displayed.
  let div = document.querySelector(".country_list");

  //   Loop through the data and display it as an accordion.
  for (let country of data.countries) {
    let details = document.createElement("details");
    let summary = document.createElement("summary");
    let p = document.createElement("p");

    summary.textContent = country.CountryName;

    details.append(summary);
    details.append(p);
    div.append(details);

    // When the user clicks on a summary element, display the cities in that country.
    summary.addEventListener("click", async function () {
      //   Clear the p element.
      p.replaceChildren();

      let cities = await listCities(country.ISO);

      let ul = document.createElement("ul");

      for (let city of cities) {
        let li = document.createElement("li");

        li.textContent = city.CityName;

        ul.append(li);
        p.append(ul);
      }
    });
  }
}

async function listCities(iso) {
  // Request the data
  let request = endpoint.for({
    iso: iso,
  });
  //   Fetch the data from the API.
  let response = await fetch(request);

  //   Parse the response as JSON.
  let data = await response.json();

  return data.cities;
}

//  Display all the data when the page loads.
listAllCountries();

// Set a listener on the search input.
let search = document.querySelector("#search");

// When the user types in the search input, display the results.
search.addEventListener("keyup", async function () {
  //  If the search input is empty, display all the data.
  if (search.value === "") {
    listAllCountries();
    return;
  }

  //   Select the div where the data will be displayed.
  let div = document.querySelector(".country_list");

  //  Clear the div.
  div.replaceChildren();

  //   Request the data.
  let request = endpoint.for({
    country: search.value,
  });

  //   Fetch the data from the API.
  let response = await fetch(request);

  //   Parse the response as JSON.
  let data = await response.json();

  //   Loop through the data and display it as an accordion.
  for (let country of data.countries) {
    let details = document.createElement("details");
    let summary = document.createElement("summary");

    summary.textContent = country.CountryName;

    details.append(summary);
    div.append(details);
  }
});
