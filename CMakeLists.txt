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



add_executable(
        TestPriorityObservers
        src/Lab2/WeatherStation/Data/Statistics.cpp
        src/Lab2/WeatherStation/Observer/Display.cpp
        src/Lab2/WeatherStation/Observer/StatsDisplay.cpp
        src/Lab2/WeatherStation/Observable/WeatherData.cpp
        tests/Unit/WeatherStation/Mock/MockObserver.cpp
        tests/Unit/WeatherStation/Mock/MockPriorityObserver1.cpp
        tests/Unit/WeatherStation/Mock/MockPriorityObserver2.cpp
        tests/Unit/WeatherStation/PriorityObserversTest.cpp
)
target_link_libraries(TestPriorityObservers PRIVATE Catch2::Catch2WithMain)
