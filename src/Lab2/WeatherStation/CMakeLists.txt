add_executable(
        WeatherStation
        Data/Statistics.cpp
        Observable/WeatherData.cpp
        main.cpp)

add_executable(
        WeatherStationPro
        Data/Statistics.cpp
        Data/ProStatistics.cpp
        Observable/WeatherDataPro.cpp
        mainPro.cpp)