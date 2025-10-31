cmake_minimum_required(VERSION 3.29)
project(OOD)

set(CMAKE_CXX_STANDARD 20)

include(FetchContent)
FetchContent_Declare(
    Catch2
    GIT_REPOSITORY https://github.com/catchorg/Catch2.git
    GIT_TAG        v3.4.0
)
FetchContent_MakeAvailable(Catch2)

add_subdirectory(src/Lab2/WeatherStation)
add_subdirectory(src/Lab3/Beverage)
add_subdirectory(src/Lab3/Stream)
add_subdirectory(src/Lab6)

add_subdirectory(tests/Unit/WeatherStation)
add_subdirectory(tests/Unit/Beverage)
add_subdirectory(tests/Unit/Stream)
add_subdirectory(tests/Unit/Adapter)

add_subdirectory(tests/Integration/Stream)