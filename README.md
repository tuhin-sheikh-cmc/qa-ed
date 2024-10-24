# Questionnaire

This runs an API that provides the questionnaire to the frontend.

## Testing

To run the unit tests: `php bin/phpunit --testsuite=unit`.

## Container

We can run this in a container (using docker or podman). Update the `.env.container` file with environment variables that would be injected into the container during the run time. Once updated, comment out the line not needed for container binary inside `run.sh` and then run that script to start the container.

