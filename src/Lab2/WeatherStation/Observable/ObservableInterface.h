#pragma once
#include "../Observer/ObserverInterface.h"

template <typename T, typename Derived>
class ObservableInterface
{
public:
    virtual void RegisterObserver(ObserverInterface<T, Derived>& observer, int priority) = 0;

    virtual void RemoveObserver(ObserverInterface<T, Derived>& observer) = 0;

    virtual void NotifyObservers() = 0;

    virtual ~ObservableInterface() = default;
};
