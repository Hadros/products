# Products

## Introduction

Products project allows you to parse products from xml file, also that project provides API to get parsed products.

## Setup

* Run `composer install`
* Configure DB connection by setting `DATABASE_URL` variable in `.env` file
* You can configure own http server or just use symfony web server, for last one run `symfony server:start`.

## Usage

Run in console `php bin/console app:parse-products-xml [URL]` where `[URL]` is url to xml file.
Open browser and navigate to https://example.org/api/products, also you can use `page` query parameter to get another list of items.
Use that url https://example.org/api/doc to read API documentation.