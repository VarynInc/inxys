#!/bin/sh
# This must be executed from within the folder of the test project.
echo "Starting unit test:"
phpunit ./inxysTest.php > test-results-inxys.log 2>> inxys-test-errors.log
echo "Test complete, check log files for results"
