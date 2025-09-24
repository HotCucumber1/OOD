#pragma once
#include "../Observer/ObserverInterface.h"

template<typename T>
class ObservableInterface
{
public:
    virtual void RegisterObserver(ObserverInterface<T>& observer, int priority) = 0;

    virtual void RemoveObserver(ObserverInterface<T>& observer) = 0;

    virtual void NotifyObservers() = 0;

    virtual ~ObservableInterface() = default;
};
