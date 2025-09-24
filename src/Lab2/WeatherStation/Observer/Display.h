#pragma once
#include "ObserverInterface.h"
#include "../Data/WeatherInfo.h"
#include <iostream>


class Display : public ObserverInterface<WeatherInfo>
{
private:
    void Update(const WeatherInfo& data) override;
};
