#include "Cipher.h"
#include "../Validator/StreamValidator.h"

#include <algorithm>
#include <functional>
#include <random>

Cipher::Cipher(const uint8_t key)
{
	GenerateCipher(key);
}

uint8_t Cipher::Encrypt(const uint8_t byte) const
{
	return m_encryptionTable[byte];
}

uint8_t Cipher::Decrypt(const uint8_t byte) const
{
	return m_decryptionTable[byte];
}

void Cipher::GenerateCipher(const uint8_t key)
{
	constexpr int cipherTableSize = 256;
	std::mt19937 generator(key);

	std::vector<uint8_t> bytes(cipherTableSize);
	for (int i = 0; i < cipherTableSize; ++i)
	{
		bytes[i] = static_cast<uint8_t>(i);
	}

	std::ranges::shuffle(bytes, generator);
	m_encryptionTable = bytes;

	m_decryptionTable.resize(cipherTableSize);
	for (int i = 0; i < cipherTableSize; ++i)
	{
		const uint8_t encrypted_byte = m_encryptionTable[i];
		m_decryptionTable[encrypted_byte] = static_cast<uint8_t>(i);
	}
}

void Cipher::EncryptBlock(const void* srcData, void* dstData, const std::streamsize size) const
{
	StreamValidator::AssertSizeIsNotNegative(size);
	StreamValidator::AssertSourceIsNotEmpty(srcData, size);

	const auto* src = static_cast<const uint8_t*>(srcData);
	auto* dst = static_cast<uint8_t*>(dstData);

	for (std::streamsize i = 0; i < size; ++i)
	{
		dst[i] = Encrypt(src[i]);
	}
}

void Cipher::DecryptBlock(const void* srcData, void* dstData, const std::streamsize size) const
{
	if (size <= 0)
	{
		return;
	}

	if (!srcData || !dstData)
	{
		throw std::invalid_argument("Null pointer provided for data block");
	}

	auto* src = static_cast<const uint8_t*>(srcData);
	auto* dst = static_cast<uint8_t*>(dstData);

	for (std::streamsize i = 0; i < size; ++i)
	{
		dst[i] = Decrypt(src[i]);
	}
}
