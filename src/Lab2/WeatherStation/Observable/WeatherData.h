#pragma once

#include "ObservableInterface.h"
#include "../Data/WeatherInfo.h"
#include "Observable.h"

class WeatherData : public Observable<WeatherInfo>
{
public:
    double GetTemperature() const;

    double GetHumidity() const;

    double GetPressure() const;

    void MeasurementsChanged();

    void SetMeasurements(double temp, double humidity, double pressure);

protected:
    WeatherInfo GetChangedData() const override;

private:
    double m_temperature = 0.0;
    double m_humidity = 0.0;
    double m_pressure = 760.0;
};
