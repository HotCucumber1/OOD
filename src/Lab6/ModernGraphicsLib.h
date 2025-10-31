#pragma once

#include <format>
#include <iostream>

namespace modern_graphics_lib
{

class CPoint
{
public:
	CPoint(const int x, const int y)
		: x(x)
		, y(y)
	{
	}
	int x;
	int y;
};

class CRGBAColor
{
public:
	CRGBAColor(
		const float r,
		const float g,
		const float b,
		const float a)
		: r(r)
		, g(g)
		, b(b)
		, a(a)
	{
	}
	float r, g, b, a;
};

class CModernGraphicsRenderer
{
public:
	explicit CModernGraphicsRenderer(std::ostream& strm)
		: m_out(strm)
	{
	}

	~CModernGraphicsRenderer()
	{
		if (m_drawing)
		{
			EndDraw();
		}
	}

	void BeginDraw()
	{
		if (m_drawing)
		{
			throw std::logic_error("Drawing has already begun");
		}
		m_out << "<draw>" << std::endl;
		m_drawing = true;
	}

	void DrawLine(const CPoint& start, const CPoint& end, const CRGBAColor& color) const
	{
		if (!m_drawing)
		{
			throw std::logic_error("DrawLine is allowed between BeginDraw()/EndDraw() only");
		}
		m_out << std::format(R"(  <line fromX="{}" fromY="{}" toX="{}" toY="{}">)", start.x, start.y, end.x, end.y) << std::endl;
		m_out << std::format(R"(    <color r="{:.2f}" g="{:.2f}" b="{:.2f}" a="{:.2f}">)", color.r, color.g, color.b, color.a) << std::endl;
		m_out << "  </line>" << std::endl;
	}

	void EndDraw()
	{
		if (!m_drawing)
		{
			throw std::logic_error("Drawing has not been started");
		}
		m_out << "</draw>" << std::endl;
		m_drawing = false;
	}

private:
	std::ostream& m_out;
	bool m_drawing = false;
};
} // namespace modern_graphics_lib