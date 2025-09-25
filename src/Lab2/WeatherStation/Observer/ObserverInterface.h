#pragma once

template<typename T, typename ObservableT>
class ObserverInterface
{
public:
    virtual void Update(const T& data, const ObservableT& subj) = 0;
    virtual ~ObserverInterface() = default;
};
