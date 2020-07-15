# DreeConfig
A multidimensional tree structured configuration library.

It is possible to configure a setting with multiple values and load the suitable value based on parameters at runtime.
 
 
 
# Overview

 
## Configuration
Class for access to configured values at runtime.

## ConfigurationLoader
Class for loading configuration from persistent source. This class as passed to the Configuration-Class to load the configured values.

## ConfigurationReader
This is a helper for configuration loaders to load read persistent configurations

## ConfigurationCompiler
Helper for configuration loaders to compile the read configuration with the specified parameters.

## ValueParser
Helper for configuration compilers to parse raw values read
 