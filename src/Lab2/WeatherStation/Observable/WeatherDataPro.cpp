#include "WeatherDataPro.h"


double WeatherDataPro::GetTemperature() const
{
	return m_temperature;
}

double WeatherDataPro::GetHumidity() const
{
	return m_humidity;
}

double WeatherDataPro::GetPressure() const
{
	return m_pressure;
}

double WeatherDataPro::GetWindSpeed() const
{
	return m_windSpeed;
}

int WeatherDataPro::GetWindDirection() const
{
	return m_windDirection;
}

void WeatherDataPro::MeasurementsChanged()
{
	NotifyObservers();
}

void WeatherDataPro::SetMeasurements(
	double temp,
	double humidity,
	double pressure,
	double windSpeed,
	int windDirection)
{
	m_humidity = humidity;
	m_temperature = temp;
	m_pressure = pressure;
	m_windSpeed = windSpeed,
	m_windDirection = windDirection;

	MeasurementsChanged();
}

WeatherInfoPro WeatherDataPro::GetChangedData() const
{
	WeatherInfoPro info;
	info.temperature = GetTemperature();
	info.humidity = GetHumidity();
	info.pressure = GetPressure();
	info.windDirection = GetWindDirection();
	info.windSpeed = GetWindSpeed();
	return info;
}