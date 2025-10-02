#include <catch2/catch_all.hpp>

#include "../../../src/Lab3/Stream/Input/DecryptDecorator.h"
#include "../../../src/Lab3/Stream/Input/FileInputStream.h"


TEST_CASE("ReadByte decryption")
{
	SECTION("Decrypt single bytes")
	{
		Cipher cipher(42);
		std::string encryptedData;
		encryptedData.push_back(cipher.Encrypt('A'));
		encryptedData.push_back(cipher.Encrypt('B'));
		encryptedData.push_back(cipher.Encrypt('C'));

		std::istringstream stream(encryptedData);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 42);

		REQUIRE(decryptor.ReadByte() == 'A');
		REQUIRE(decryptor.ReadByte() == 'B');
		REQUIRE(decryptor.ReadByte() == 'C');
		REQUIRE(decryptor.IsEOF());
	}
}

TEST_CASE("ReadBlock decryption")
{
	SECTION("Decrypt block of data")
	{
		Cipher cipher(123);
		std::string original = "HelloWorld";
		std::string encrypted_data;

		for (char c : original)
		{
			encrypted_data.push_back(cipher.Encrypt(static_cast<uint8_t>(c)));
		}

		std::istringstream stream(encrypted_data);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 123);

		std::vector<uint8_t> buffer(original.size());
		std::streamsize result = decryptor.ReadBlock(buffer.data(), buffer.size());

		REQUIRE(result == original.size());
		REQUIRE(std::string(buffer.begin(), buffer.end()) == original);
		REQUIRE(decryptor.IsEOF() == true);
	}

	SECTION("Decrypt empty block")
	{
		std::string encrypted_data = "test";
		std::istringstream stream(encrypted_data);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 33);

		std::vector<uint8_t> buffer(5);
		std::streamsize result = decryptor.ReadBlock(buffer.data(), 0);

		REQUIRE(result == 0);
		REQUIRE(!decryptor.IsEOF());
	}
}

TEST_CASE("ReadBlock with null buffer")
{
	std::string encrypted_data = "test";
	std::istringstream stream(encrypted_data);
	auto fileInput = std::make_unique<FileInputStream>(stream);
	DecryptDecorator decryptor(std::move(fileInput), 25);

	SECTION("Null buffer with zero size is allowed")
	{
		std::streamsize result = decryptor.ReadBlock(nullptr, 0);
		REQUIRE(result == 0);

		std::vector<uint8_t> buffer(4);
		result = decryptor.ReadBlock(buffer.data(), buffer.size());
		REQUIRE(result == 4);
	}
}


TEST_CASE("Different decryption keys")
{
	SECTION("Wrong key produces garbage")
	{
		Cipher encrypt_cipher(10);
		std::string original = "SecretData";
		std::string encrypted_data;

		for (const char c : original)
		{
			encrypted_data.push_back(encrypt_cipher.Encrypt(static_cast<uint8_t>(c)));
		}

		std::istringstream stream(encrypted_data);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 20);

		std::vector<uint8_t> buffer(original.size());
		std::streamsize result = decryptor.ReadBlock(buffer.data(), buffer.size());

		REQUIRE(result == original.size());
		REQUIRE(std::string(buffer.begin(), buffer.end()) != original);
	}

	SECTION("Correct key produces original data")
	{
		Cipher cipher(50);
		std::string original = "TestData";
		std::string encrypted_data;

		for (char c : original)
		{
			encrypted_data.push_back(cipher.Encrypt(static_cast<uint8_t>(c)));
		}

		std::istringstream stream(encrypted_data);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 50);

		std::vector<uint8_t> buffer(original.size());
		std::streamsize result = decryptor.ReadBlock(buffer.data(), buffer.size());

		REQUIRE(result == original.size());
		REQUIRE(std::string(buffer.begin(), buffer.end()) == original);
	}
}

TEST_CASE("IsEOF method behavior")
{
	SECTION("IsEOF on empty stream")
	{
		std::istringstream empty_stream("");
		auto fileInput = std::make_unique<FileInputStream>(empty_stream);
		DecryptDecorator decryptor(std::move(fileInput), 33);

		REQUIRE(decryptor.IsEOF() == true);
		REQUIRE_THROWS_AS(decryptor.ReadByte(), std::exception);
	}

	SECTION("IsEOF changes after reads")
	{
		Cipher cipher(66);
		std::string original = "ABC";
		std::string encrypted_data;

		for (const char c : original)
		{
			encrypted_data.push_back(cipher.Encrypt(static_cast<uint8_t>(c)));
		}

		std::istringstream stream(encrypted_data);
		auto fileInput = std::make_unique<FileInputStream>(stream);
		DecryptDecorator decryptor(std::move(fileInput), 66);

		REQUIRE(decryptor.IsEOF() == false);
		REQUIRE(decryptor.ReadByte() == 'A');
		REQUIRE(decryptor.IsEOF() == false);
		REQUIRE(decryptor.ReadByte() == 'B');
		REQUIRE(decryptor.IsEOF() == false);
		REQUIRE(decryptor.ReadByte() == 'C');
		REQUIRE(decryptor.IsEOF() == true);
	}
}
