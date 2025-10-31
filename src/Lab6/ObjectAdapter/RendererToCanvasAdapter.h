#pragma once

#include "../GraphicsLib.h"
#include "../ModernGraphicsLib.h"

class RendererToCanvasAdapter final : public graphics_lib::ICanvas
{
public:
	explicit RendererToCanvasAdapter(modern_graphics_lib::CModernGraphicsRenderer& renderer)
		: m_renderer(renderer)
		, m_lastPoint({ 0, 0 })
		, m_color(0, 0, 0, 0)
	{
		m_renderer.BeginDraw();
	}

	void SetColor(const uint32_t rgbColor) override
	{
		const uint8_t r8 = (rgbColor >> 24) & 0xFF;
		const uint8_t g8 = (rgbColor >> 16) & 0xFF;
		const uint8_t b8 = (rgbColor >> 8) & 0xFF;
		const uint8_t a8 = rgbColor & 0xFF;

		m_color.r = r8 / 255.0;
		m_color.g = g8 / 255.0;
		m_color.b = b8 / 255.0;
		m_color.a = a8 / 255.0;
	}

	void MoveTo(const int x, const int y) override
	{
		m_lastPoint = { x, y };
	}

	void LineTo(int x, int y) override
	{
		m_renderer.DrawLine(
			m_lastPoint,
			{ x, y },
			m_color);

		m_lastPoint = { x, y };
	}

private:
	modern_graphics_lib::CModernGraphicsRenderer& m_renderer;
	modern_graphics_lib::CPoint m_lastPoint;
	modern_graphics_lib::CRGBAColor m_color;
};