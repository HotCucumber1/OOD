#pragma once

template<typename T>
class ObserverInterface
{
public:
    virtual void Update(const T& data) = 0;
    virtual ~ObserverInterface() = default;
};
