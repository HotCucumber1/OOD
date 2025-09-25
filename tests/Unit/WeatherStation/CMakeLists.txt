add_executable(
        TestPriorityObservers
        ../../../src/Lab2/WeatherStation/Data/Statistics.cpp
        PriorityObserversTest.cpp
)
add_executable(
        MultyObservableTest
        ../../../src/Lab2/WeatherStation/Data/Statistics.cpp
        MultyObservableTest.cpp
)

target_link_libraries(TestPriorityObservers PRIVATE Catch2::Catch2WithMain)
target_link_libraries(MultyObservableTest PRIVATE Catch2::Catch2WithMain)