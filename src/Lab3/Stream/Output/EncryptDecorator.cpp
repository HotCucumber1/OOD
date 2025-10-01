#include "../Output/EncryptDecorator.h"

void EncryptDecorator::WriteByte(const uint8_t data)
{
	const auto encryptedByte = m_ciper.Encrypt(data);
	m_output->WriteByte(encryptedByte);
}

void EncryptDecorator::WriteBlock(const void* srcData, std::streamsize size)
{
	std::vector<uint8_t> encryptedData(size);
	m_ciper.EncryptBlock(srcData, encryptedData.data(), size);
	m_output->WriteBlock(encryptedData.data(), size);
}

void EncryptDecorator::Close()
{
	m_output->Close();
}
