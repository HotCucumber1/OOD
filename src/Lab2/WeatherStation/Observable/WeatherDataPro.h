#pragma once

#include "../WeatherInfoPro.h"
#include "Observable.h"

class WeatherDataPro : public Observable<WeatherInfoPro, WeatherDataPro>
{
public:
	double GetTemperature() const;

	double GetHumidity() const;

	double GetPressure() const;

	double GetWindSpeed() const;

	int GetWindDirection() const;

	void MeasurementsChanged();

	void SetMeasurements(
		double temp,
		double humidity,
		double pressure,
		double windSpeed,
		int windDirection);
protected:
	WeatherInfoPro GetChangedData() const override;

private:
	double m_temperature = 0.0;
	double m_humidity = 0.0;
	double m_pressure = 760.0;

	double m_windSpeed = 0;
	int m_windDirection = 0;
};
