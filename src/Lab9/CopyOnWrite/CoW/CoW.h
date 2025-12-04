#pragma once
#include <cassert>
#include <memory>

template <typename T>
class CoW
{
	template <typename U>
	struct CopyConstr
	{
		static std::unique_ptr<U> Copy(const U& other)
		{
			return std::make_unique<T>(other);
		}
	};

	template <typename U>
	struct CloneConstr
	{
		static std::unique_ptr<U> Copy(const U& other)
		{
			return other.Clone();
		}
	};

	using CopyClass = std::conditional_t<
		!std::is_abstract_v<T> && std::is_copy_constructible_v<T>,
		CopyConstr<T>,
		CloneConstr<T>>;

	class WriteProxy
	{
	public:
		explicit WriteProxy(T* p)
			: m_p(p)
		{
		}

		T& operator*() const& = delete;

		T* operator->() const& = delete;

		[[nodiscard]] T& operator*() const&& noexcept
		{
			return *m_p;
		}

		T* operator->() const&&
		{
			return m_p;
		}

	private:
		T* m_p;
	};

public:
	template <typename... Args, typename = std::enable_if_t<!std::is_abstract_v<T>>>
	explicit CoW(Args&&... args)
		: m_shared(std::make_shared<T>(std::forward<Args>(args)...))
	{
	}

	// avoid duplicate object
	CoW(CoW&& rhs) noexcept
		: m_shared(std::move(rhs.m_shared))
	{
	}

	explicit CoW(std::unique_ptr<T> pUniqueObj)
		: m_shared(std::move(pUniqueObj))
	{
	}

	CoW& operator=(CoW&& rhs) noexcept
	{
		m_shared = std::move(rhs.m_shared);
		return *this;
	}

	template <typename U>
	explicit CoW(CoW<U>& rhs)
		: m_shared(rhs.m_shared)
	{
	}

	template <typename U>
	CoW& operator=(CoW<U>& rhs)
	{
		m_shared = rhs.m_shared;
		return *this;
	}

	CoW(const CoW& rhs)
		: m_shared(rhs.m_shared)
	{
	}

	CoW& operator=(const CoW& rhs) = default;

	const T& operator*() const&& noexcept = delete;

	const T* operator->() const&& noexcept = delete;

	const T& operator*() const& noexcept
	{
		assert(m_shared);
		return *m_shared;
	}

	const T* operator->() const& noexcept
	{
		assert(m_shared);
		return m_shared.get();
	}

	[[nodiscard]] WriteProxy operator--(int) &
	{
		assert(m_shared);
		EnsureUnique();
		return WriteProxy(m_shared.get());
	}

	[[nodiscard]] WriteProxy Write() &
	{
		assert(m_shared);
		EnsureUnique();
		return WriteProxy(m_shared.get());
	}

private:
	void EnsureUnique()
	{
		if (m_shared.use_count() != 1)
		{
			m_shared = CopyClass::Copy(*m_shared);
		}
	}

	std::shared_ptr<T> m_shared;
};