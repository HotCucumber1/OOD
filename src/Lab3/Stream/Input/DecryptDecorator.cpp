#include "DecryptDecorator.h"

bool DecryptDecorator::IsEOF() const
{
	return m_input->IsEOF();
}

uint8_t DecryptDecorator::ReadByte()
{
	auto byte = m_input->ReadByte();
	return m_ciper.Decrypt(byte);
}

std::streamsize DecryptDecorator::ReadBlock(void* dstBuffer, const std::streamsize size)
{
	std::vector<uint8_t> encryptedData(size);

	std::streamsize bytesRead = m_input->ReadBlock(encryptedData.data(), size);

	if (bytesRead > 0)
	{
		m_ciper.DecryptBlock(encryptedData.data(), dstBuffer, bytesRead);
	}

	return bytesRead;
}
