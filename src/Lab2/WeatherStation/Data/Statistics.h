#pragma once

#include <string>
#include <algorithm>
#include <limits>

class Statistics
{
public:
    explicit Statistics(std::string name);

    void Update(double newValue);

    void PrintInfo() const;

private:
    std::string m_name;
    double m_minValue = std::numeric_limits<double>::infinity();;
    double m_maxValue = -std::numeric_limits<double>::infinity();
    double m_accValue = 0;
    unsigned m_count = 0;
};
