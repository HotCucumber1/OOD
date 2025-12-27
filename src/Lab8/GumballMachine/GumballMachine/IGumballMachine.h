#pragma once

class IGumballMachine
{
public:
	const int MAX_PENNIES = 5;

	virtual void ReleaseBall() = 0;

	virtual unsigned GetBallCount() const = 0;

	virtual unsigned GetQuarterCount() const = 0;

	virtual void AddQuarter() = 0;

	virtual void RemoveOneQuarter() = 0;

	virtual void AddBalls(unsigned count) = 0;

	virtual void RemoveAllQuarters() = 0;

	virtual void SetSoldOutState() = 0;

	virtual void SetNoQuarterState() = 0;

	virtual void SetSoldState() = 0;

	virtual void SetHasQuarterState() = 0;

	virtual void SetMaxQuartersState() = 0;

	virtual ~IGumballMachine() = default;
};
