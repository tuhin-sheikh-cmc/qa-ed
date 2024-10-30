# Questionnaire

This runs an API that provides the questionnaire to the frontend. Questionnaires could be in MySQL DB or NoSQL DB. Here we've stored this in a json file. Each question is in a seperate file. The question for the test is in [ed.json](src/data/ed.json) file.

Frontend would send `POST` request to API endpoint `/api/v1/questionnaire`.

The first request would have a body/payload similar to this:
```json
{
    "questionnaire": "ed"
}
```

This will looks for a json file with the 'questionnaire' name and would find the first question and would return it. Response would look like this:
```json
{
  "id": "q1",
  "question": "Do you have difficulty getting or maintaining an erection?",
  "options": [
    {
      "value": "Yes",
      "exclude": [],
      "nextStep": "q2",
      "suggest": ""
    },
    {
      "value": "No",
      "nextStep": "end",
      "exclude": [
        "all"
      ],
      "suggest": ""
    }
  ]
}
```

Following request would have extra param in body:
```json
{
    "questionnaire": "ed",
    "question": "q2a"
}
```

And this will return a response like this:
```json
{
  "id": "q2a",
  "question": "Was the Viagra or Sildenafil product you tried before effective?",
  "options": [
    {
      "value": "Yes",
      "suggest": "sld50",
      "exclude": [],
      "nextStep": "q3"
    },
    {
      "value": "No",
      "suggest": "tdl20",
      "exclude": [],
      "nextStep": "q3"
    }
  ]
}
```

## Testing

To run the unit tests: `php bin/phpunit --testsuite=unit`.

## Container

We can run this in a container (using docker or podman). Update the `.env.container` file with environment variables that would be injected into the container during the run time. Once updated, comment out the line not needed for container binary inside `run.sh` and then run that script to start the container.

