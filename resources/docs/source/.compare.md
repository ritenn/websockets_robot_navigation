---
title: API Reference

language_tabs:
- php
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_b1e635ced5acc83180197b5838c7161f -->
## List configurations

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/configuration',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```bash
curl -X GET \
    -G "http://localhost/api/configuration" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/configuration"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "error": false,
    "message": "Configuration list.",
    "data": [
        {
            "uuid": "7c5b21e2-2079-46e9-8651-80e805dc600f",
            "name": "4W Arduino ESP8266 V1",
            "hostname": "192.168.0.25",
            "port": 80,
            "rotation_speed": 140,
            "left_engine_speed": 100,
            "right_engine_speed": 100,
            "primary": true,
            "online": false
        }
    ]
}
```

### HTTP Request
`GET api/configuration`


<!-- END_b1e635ced5acc83180197b5838c7161f -->

<!-- START_4c2820ea36c00a90e490af7df4cfb1d0 -->
## Store a newly created resource in storage.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/configuration',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```bash
curl -X POST \
    "http://localhost/api/configuration" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/configuration"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/configuration`


<!-- END_4c2820ea36c00a90e490af7df4cfb1d0 -->

<!-- START_7dc9456c97d9bfc41a974a7403387bf7 -->
## Remove configuration

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/configuration/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```bash
curl -X DELETE \
    "http://localhost/api/configuration/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/configuration/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/configuration/{configuration}`


<!-- END_7dc9456c97d9bfc41a974a7403387bf7 -->

<!-- START_53be1e9e10a08458929a2e0ea70ddb86 -->
## Display a listing of the resource.

> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```bash
curl -X GET \
    -G "http://localhost/" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET /`


<!-- END_53be1e9e10a08458929a2e0ea70ddb86 -->

<!-- START_826232d85c80bf415d08734c601c1d2b -->
## navigation/manual/{configuration}
> Example request:

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/navigation/manual/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```bash
curl -X GET \
    -G "http://localhost/navigation/manual/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/navigation/manual/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "error": true,
    "message": "Not found",
    "data": []
}
```

### HTTP Request
`GET navigation/manual/{configuration}`


<!-- END_826232d85c80bf415d08734c601c1d2b -->


